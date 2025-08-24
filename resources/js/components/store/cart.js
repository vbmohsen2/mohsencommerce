import { defineStore } from 'pinia'
import { useForm } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

export const useCartStore = defineStore('cart', {
    state: () => ({
        items: [],
    }),
    getters: {
        total(state) {
            return state.items.reduce((sum, item) => sum + item.price * item.quantity, 0)
        },
        count(state) {
            return state.items.reduce((sum, item) => sum + item.quantity, 0)
        }
    },
    actions: {
        setItems(items) {
            this.items = items || []
        },
        addLocal(item) {
            const idx = this.items.findIndex(i => i.id === item.id && i.code === item.code)
            if (idx !== -1) {
                this.items[idx].quantity += item.quantity ?? 1
            } else {
                this.items.push({ ...item, quantity: item.quantity ?? 1 })
            }
        },
        async increase(id, code) {
            const form = useForm()
            const item = this.items.find(i => i.id === id && i.code === code)
            if (item) item.quantity++
            try {
                await form.post(route('cart.increase', id), { data: { code } })
            } catch {
                if (item) item.quantity--
            }
        },
        async decrease(id, code) {
            const form = useForm()
            const item = this.items.find(i => i.id === id && i.code === code)
            if (item && item.quantity > 1) item.quantity--
            try {
                await form.post(route('cart.decrease', id), { data: { code } })
            } catch {
                if (item) item.quantity++
            }
        },
        async remove(id, code) {
            const form = useForm()
            const index = this.items.findIndex(i => i.id === id && i.code === code)
            let removedItem = null
            if (index !== -1) removedItem = this.items.splice(index, 1)[0]
            try {
                await form.delete(route('cart.remove', id), { data: { code } })
            } catch {
                if (removedItem) this.items.splice(index, 0, removedItem)
            }
        },
        async clear() {
            const form = useForm()
            const oldItems = [...this.items]
            this.items = []
            try {
                await form.post(route('cart.clear'))
            } catch {
                this.items = oldItems
            }
        }
    }
})
