import { ssrRenderAttrs, ssrRenderAttr, ssrInterpolate, ssrRenderList, ssrIncludeBooleanAttr, ssrRenderClass, ssrRenderComponent, ssrLooseContain, ssrLooseEqual, ssrRenderStyle, ssrRenderSlot } from "vue/server-renderer";
import { usePage, Link, Head, useForm, createInertiaApp } from "@inertiajs/vue3";
import { mergeProps, useSSRContext, computed, ref, onMounted, watch, unref, withCtx, createVNode, createBlock, openBlock, Fragment, renderList, toDisplayString, onUnmounted, createTextVNode, createSSRApp, h } from "vue";
import axios from "axios";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay, Pagination } from "swiper/modules";
import Swiper$1 from "swiper";
import { useHead, createHead } from "@vueuse/head";
import Swiper$2 from "swiper/bundle";
import "autoprefixer";
import "vue-toast-notification";
import { defineStore, createPinia } from "pinia";
import { route } from "ziggy-js";
import debounce from "lodash/debounce.js";
import createServer from "@inertiajs/vue3/server";
import { renderToString } from "@vue/server-renderer";
const _export_sfc = (sfc, props) => {
  const target = sfc.__vccOpts || sfc;
  for (const [key, val] of props) {
    target[key] = val;
  }
  return target;
};
const _sfc_main$q = {
  __name: "ProductCard",
  __ssrInlineRender: true,
  props: {
    product: {
      type: Object,
      required: true
    }
  },
  setup(__props) {
    const formatPrice = (price) => {
      return new Intl.NumberFormat("fa-IR", {
        maximumFractionDigits: 0
      }).format(price) + " تومان";
    };
    function getMainImage(imageJson) {
      try {
        const images = JSON.parse(imageJson);
        return "/storage/images/products/" + images.main;
      } catch {
        return "/placeholder.png";
      }
    }
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<a${ssrRenderAttrs(mergeProps({
        href: `/product/${__props.product.slug}`,
        class: "bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 border border-transparent hover:border-gray-300 p-2 flex flex-col group"
      }, _attrs))} data-v-b6cc8b45><div class="relative w-full h-60 overflow-hidden rounded-2xl" data-v-b6cc8b45><img${ssrRenderAttr("src", getMainImage(__props.product.images))}${ssrRenderAttr("alt", __props.product.name)} class="w-full h-full md:object-cover object-scale-down transition-transform duration-300 group-hover:scale-105" data-v-b6cc8b45></div><h3 class="text-sm font-medium mt-3 mb-1 text-gray-800 line-clamp-2 leading-snug" data-v-b6cc8b45>${ssrInterpolate(__props.product.name)}</h3><div class="mt-auto flex items-center justify-between" data-v-b6cc8b45><div class="flex items-center gap-2" data-v-b6cc8b45><div class="text-gray-800 font-bold text-lg" data-v-b6cc8b45>${ssrInterpolate(formatPrice(Number(__props.product.discount_price) > 0 ? __props.product.discount_price : __props.product.price))}</div>`);
      if (Number(__props.product.discount_price) > 0) {
        _push(`<span class="text-xs text-white bg-red-500 rounded-full px-2 py-0.5" data-v-b6cc8b45> ٪${ssrInterpolate(Math.round((1 - __props.product.discount_price / __props.product.price) * 100))}</span>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div>`);
      if (Number(__props.product.discount_price) > 0) {
        _push(`<div class="text-xs text-red-500 line-through" data-v-b6cc8b45>${ssrInterpolate(formatPrice(__props.product.price))}</div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div></a>`);
    };
  }
};
const _sfc_setup$q = _sfc_main$q.setup;
_sfc_main$q.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/category/ProductCard.vue");
  return _sfc_setup$q ? _sfc_setup$q(props, ctx) : void 0;
};
const ProductCard = /* @__PURE__ */ _export_sfc(_sfc_main$q, [["__scopeId", "data-v-b6cc8b45"]]);
const __vite_glob_0_3 = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: ProductCard
}, Symbol.toStringTag, { value: "Module" }));
const _sfc_main$p = {
  __name: "filterSidebar",
  __ssrInlineRender: true,
  props: {
    filters: Array,
    brands: Array,
    modelValue: Object,
    disabled: Boolean
    // جدید
  },
  emits: ["update:modelValue"],
  setup(__props, { emit: __emit }) {
    const props = __props;
    const hasSelectedFilters = computed(() => {
      if (!props.modelValue) return false;
      return Object.values(props.modelValue).some((val) => Array.isArray(val) && val.length > 0);
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({
        class: [{ "opacity-50 pointer-events-none": __props.disabled }, "filter-container p-4 bg-white rounded shadow border border-gray-200"]
      }, _attrs))} data-v-8041429e><div class="flex justify-between items-center mb-4" data-v-8041429e><h3 class="font-semibold text-lg" data-v-8041429e>فیلترها</h3>`);
      if (hasSelectedFilters.value && !__props.disabled) {
        _push(`<button class="text-red-600 hover:text-red-800 text-sm" data-v-8041429e> پاک کردن همه </button>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div>`);
      if (hasSelectedFilters.value) {
        _push(`<div class="mb-4 flex flex-wrap gap-2" data-v-8041429e>`);
        if (Array.isArray(__props.modelValue.brand)) {
          _push(`<!--[-->`);
          ssrRenderList(__props.modelValue.brand, (brand) => {
            _push(`<span class="flex items-center bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm" data-v-8041429e>${ssrInterpolate(brand)} <button class="mr-1 text-blue-600 hover:text-blue-900" aria-label="حذف برند"${ssrIncludeBooleanAttr(__props.disabled) ? " disabled" : ""} data-v-8041429e> × </button></span>`);
          });
          _push(`<!--]-->`);
        } else {
          _push(`<!---->`);
        }
        _push(`<!--[-->`);
        ssrRenderList(__props.filters, (filter) => {
          _push(`<!--[-->`);
          if (Array.isArray(__props.modelValue[filter.name])) {
            _push(`<!--[-->`);
            ssrRenderList(__props.modelValue[filter.name], (option) => {
              _push(`<span class="flex items-center bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm" data-v-8041429e>${ssrInterpolate(option)} <button class="mr-1 text-green-600 hover:text-green-900" aria-label="حذف فیلتر"${ssrIncludeBooleanAttr(__props.disabled) ? " disabled" : ""} data-v-8041429e> × </button></span>`);
            });
            _push(`<!--]-->`);
          } else {
            _push(`<!---->`);
          }
          _push(`<!--]-->`);
        });
        _push(`<!--]--></div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`<details class="mb-3 border rounded p-3" data-v-8041429e><summary class="cursor-pointer font-medium select-none flex justify-between items-center" data-v-8041429e> برند <svg class="w-4 h-4 transition-transform duration-300 group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-v-8041429e><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" data-v-8041429e></path></svg></summary><div class="mt-2 space-y-1 max-h-40 overflow-auto" data-v-8041429e><!--[-->`);
      ssrRenderList(__props.brands, (brand) => {
        _push(`<label class="flex items-center gap-2 cursor-pointer" data-v-8041429e><input type="checkbox"${ssrRenderAttr("value", brand)}${ssrIncludeBooleanAttr(Array.isArray(__props.modelValue.brand) && __props.modelValue.brand.includes(brand)) ? " checked" : ""}${ssrIncludeBooleanAttr(__props.disabled) ? " disabled" : ""} class="cursor-pointer" data-v-8041429e> ${ssrInterpolate(brand)}</label>`);
      });
      _push(`<!--]--></div></details><!--[-->`);
      ssrRenderList(__props.filters, (filter) => {
        _push(`<div class="mb-3" data-v-8041429e><details class="border rounded p-3" data-v-8041429e><summary class="cursor-pointer font-medium select-none flex justify-between items-center" data-v-8041429e>${ssrInterpolate(filter.name)} <svg class="w-4 h-4 transition-transform duration-300 group-open:rotate-180" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-v-8041429e><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" data-v-8041429e></path></svg></summary><div class="mt-2 space-y-1 max-h-40 overflow-auto" data-v-8041429e><!--[-->`);
        ssrRenderList(filter.options, (option) => {
          _push(`<label class="flex items-center gap-2 cursor-pointer" data-v-8041429e><input type="checkbox"${ssrRenderAttr("value", option)}${ssrIncludeBooleanAttr(Array.isArray(__props.modelValue[filter.slug]) && __props.modelValue[filter.slug].includes(option)) ? " checked" : ""}${ssrIncludeBooleanAttr(__props.disabled) ? " disabled" : ""} class="cursor-pointer" data-v-8041429e> ${ssrInterpolate(option)}</label>`);
        });
        _push(`<!--]--></div></details></div>`);
      });
      _push(`<!--]--></div>`);
    };
  }
};
const _sfc_setup$p = _sfc_main$p.setup;
_sfc_main$p.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/category/filterSidebar.vue");
  return _sfc_setup$p ? _sfc_setup$p(props, ctx) : void 0;
};
const FilterSidebar = /* @__PURE__ */ _export_sfc(_sfc_main$p, [["__scopeId", "data-v-8041429e"]]);
const __vite_glob_0_4 = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: FilterSidebar
}, Symbol.toStringTag, { value: "Module" }));
const _sfc_main$o = {
  __name: "MobileFilterDrawer",
  __ssrInlineRender: true,
  props: {
    filters: Array,
    brands: Array,
    modelValue: Object,
    loading: Boolean,
    show: Boolean
  },
  emits: ["update:modelValue", "close"],
  setup(__props, { emit: __emit }) {
    const props = __props;
    const hasSelectedFilters = computed(() => {
      if (!props.modelValue) return false;
      return Object.values(props.modelValue).some((val) => Array.isArray(val) && val.length > 0);
    });
    return (_ctx, _push, _parent, _attrs) => {
      if (__props.show) {
        _push(`<div${ssrRenderAttrs(mergeProps({ class: "fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-start pt-16 px-4 overflow-auto" }, _attrs))} data-v-f5cdc7a3><div class="${ssrRenderClass([{ "opacity-50 pointer-events-none": __props.loading }, "bg-white rounded-md w-full max-w-md p-4 shadow-lg"])}" data-v-f5cdc7a3><button class="mb-4 text-right w-full font-semibold text-gray-600 hover:text-gray-900" aria-label="بستن فیلترها" data-v-f5cdc7a3> ✕ </button>`);
        if (hasSelectedFilters.value && !__props.loading) {
          _push(`<div class="mb-4 flex justify-between items-center" data-v-f5cdc7a3><h3 class="font-semibold text-lg" data-v-f5cdc7a3>فیلترها</h3><button class="text-red-600 hover:text-red-800 text-sm" data-v-f5cdc7a3> پاک کردن همه </button></div>`);
        } else {
          _push(`<!---->`);
        }
        if (Array.isArray(__props.modelValue.brand)) {
          _push(`<!--[-->`);
          ssrRenderList(__props.modelValue.brand, (brand) => {
            _push(`<span class="flex items-center bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm" data-v-f5cdc7a3>${ssrInterpolate(brand)} <button class="mr-1 text-blue-600 hover:text-blue-900" aria-label="حذف برند"${ssrIncludeBooleanAttr(__props.loading) ? " disabled" : ""} data-v-f5cdc7a3> × </button></span>`);
          });
          _push(`<!--]-->`);
        } else {
          _push(`<!---->`);
        }
        _push(`<!--[-->`);
        ssrRenderList(__props.filters, (filter) => {
          _push(`<!--[-->`);
          if (Array.isArray(__props.modelValue[filter.name])) {
            _push(`<!--[-->`);
            ssrRenderList(__props.modelValue[filter.name], (option) => {
              _push(`<span class="flex items-center bg-green-100 text-green-800 px-2 py-1 rounded-full text-sm" data-v-f5cdc7a3>${ssrInterpolate(option)} <button class="mr-1 text-green-600 hover:text-green-900" aria-label="حذف فیلتر"${ssrIncludeBooleanAttr(__props.loading) ? " disabled" : ""} data-v-f5cdc7a3> × </button></span>`);
            });
            _push(`<!--]-->`);
          } else {
            _push(`<!---->`);
          }
          _push(`<!--]-->`);
        });
        _push(`<!--]--><details data-v-f5cdc7a3><summary class="font-bold mb-2 cursor-pointer" data-v-f5cdc7a3>برند</summary><div class="space-y-2 mt-2" data-v-f5cdc7a3><!--[-->`);
        ssrRenderList(__props.brands, (brand) => {
          _push(`<label class="flex items-center space-x-2 rtl:space-x-reverse" data-v-f5cdc7a3><input type="checkbox"${ssrRenderAttr("value", brand)}${ssrIncludeBooleanAttr(Array.isArray(__props.modelValue.brand) && __props.modelValue.brand.includes(brand)) ? " checked" : ""}${ssrIncludeBooleanAttr(__props.loading) ? " disabled" : ""} class="cursor-pointer" data-v-f5cdc7a3><span data-v-f5cdc7a3>${ssrInterpolate(brand)}</span></label>`);
        });
        _push(`<!--]--></div></details><!--[-->`);
        ssrRenderList(__props.filters, (filter) => {
          _push(`<div class="mt-4" data-v-f5cdc7a3><details data-v-f5cdc7a3><summary class="font-bold cursor-pointer" data-v-f5cdc7a3>${ssrInterpolate(filter.name)}</summary><div class="space-y-2 mt-2" data-v-f5cdc7a3><!--[-->`);
          ssrRenderList(filter.options, (option) => {
            _push(`<label class="flex items-center space-x-2 rtl:space-x-reverse" data-v-f5cdc7a3><input type="checkbox"${ssrRenderAttr("value", option)}${ssrIncludeBooleanAttr(Array.isArray(__props.modelValue[filter.name]) && __props.modelValue[filter.name].includes(option)) ? " checked" : ""}${ssrIncludeBooleanAttr(__props.loading) ? " disabled" : ""} class="cursor-pointer" data-v-f5cdc7a3><span data-v-f5cdc7a3>${ssrInterpolate(option)}</span></label>`);
          });
          _push(`<!--]--></div></details></div>`);
        });
        _push(`<!--]--></div></div>`);
      } else {
        _push(`<!---->`);
      }
    };
  }
};
const _sfc_setup$o = _sfc_main$o.setup;
_sfc_main$o.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/category/MobileFilterDrawer.vue");
  return _sfc_setup$o ? _sfc_setup$o(props, ctx) : void 0;
};
const MobileFilterDrawer = /* @__PURE__ */ _export_sfc(_sfc_main$o, [["__scopeId", "data-v-f5cdc7a3"]]);
const __vite_glob_0_2 = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: MobileFilterDrawer
}, Symbol.toStringTag, { value: "Module" }));
const _sfc_main$n = {
  __name: "CategoryProducts",
  __ssrInlineRender: true,
  setup(__props) {
    const products = ref([]);
    const filters = ref([]);
    const brands = ref([]);
    const selectedFilters = ref({});
    const sortBy = ref("latest");
    const page = ref(1);
    const loading = ref(false);
    const hasMore = ref(true);
    const showMobileFilters = ref(false);
    const currentPage = ref(1);
    const totalPages = ref(1);
    const categoryId = ref();
    const breadcrumb = ref();
    const pageProps = usePage().props;
    const categoryslug = pageProps.category.slug;
    brands.value = pageProps.brands;
    filters.value = pageProps.attributes;
    const firstLoad = ref(true);
    const fetchProducts = async (reset = false) => {
      if (loading.value || !hasMore.value && !reset) return;
      loading.value = true;
      if (firstLoad.value) {
        products.value = pageProps.products.data;
        categoryId.value = pageProps.category.id;
        totalPages.value = pageProps.products.last_page || 1;
        currentPage.value = 1;
        hasMore.value = !!pageProps.products.next_page_url;
        page.value = 2;
        firstLoad.value = false;
        loading.value = false;
        return;
      }
      if (reset) {
        page.value = 1;
        currentPage.value = 1;
        products.value = [];
        hasMore.value = true;
      }
      const filtersWithoutBrand = { ...selectedFilters.value };
      delete filtersWithoutBrand.brand;
      const { data } = await axios.get(`/api/categories/${categoryslug}/products`, {
        params: {
          brand: selectedFilters.value.brand,
          filters: filtersWithoutBrand,
          sort_by: sortBy.value,
          page: page.value
        }
      });
      if (reset) {
        products.value = data.products.data;
      } else {
        products.value.push(...data.products.data);
      }
      categoryId.value = data.category_id;
      totalPages.value = data.products.last_page || 1;
      currentPage.value = page.value;
      hasMore.value = !!data.products.next_page_url;
      page.value++;
      loading.value = false;
      if (typeof window !== "undefined") {
        const newUrl = `?page=${currentPage.value}`;
        window.history.pushState({}, "", newUrl);
      }
    };
    const categoryView = async () => {
      breadcrumb.value = usePage().props.breadcrumb;
    };
    onMounted(() => {
      if (typeof window !== "undefined") {
        window.addEventListener("scroll", () => {
          if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 500) {
            fetchProducts();
          }
        });
      }
    });
    watch([selectedFilters, sortBy], () => {
      fetchProducts(true);
    });
    computed(() => {
      const range = [];
      const start = Math.max(1, currentPage.value - 2);
      const end = Math.min(totalPages.value, currentPage.value + 2);
      for (let i = start; i <= end; i++) {
        range.push(i);
      }
      return range;
    });
    fetchProducts();
    categoryView();
    categoryView();
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[--><div class="text-sm text-gray-500 px-2 md:hidden flex flex-wrap gap-1 pb-3 rtl:flex-row-reverse" data-v-d7d3a4c3><a href="/" data-v-d7d3a4c3>فروشگاه اینترنتی</a><!--[-->`);
      ssrRenderList(breadcrumb.value, (cat) => {
        _push(`<!--[--><span data-v-d7d3a4c3>/</span><a${ssrRenderAttr("href", `/category/${cat.slug}`)} class="hover:text-green-600 transition" data-v-d7d3a4c3>${ssrInterpolate(cat.name)}</a><!--]-->`);
      });
      _push(`<!--]--></div><div class="grid grid-cols-1 px-2 md:grid-cols-[250px_1fr] gap-4 relative" data-v-d7d3a4c3><aside class="hidden md:block sticky top-36 h-fit" data-v-d7d3a4c3><div class="text-sm text-gray-500 flex flex-wrap gap-1 pb-3 rtl:flex-row-reverse" data-v-d7d3a4c3><a href="/" data-v-d7d3a4c3>فروشگاه اینترنتی</a><!--[-->`);
      ssrRenderList(breadcrumb.value, (cat) => {
        _push(`<!--[--><span data-v-d7d3a4c3>/</span><a${ssrRenderAttr("href", `/category/${cat.slug}`)} class="hover:text-green-600 transition" data-v-d7d3a4c3>${ssrInterpolate(cat.name)}</a><!--]-->`);
      });
      _push(`<!--]--></div>`);
      _push(ssrRenderComponent(FilterSidebar, {
        filters: filters.value,
        brands: brands.value,
        modelValue: selectedFilters.value,
        "onUpdate:modelValue": ($event) => selectedFilters.value = $event,
        disabled: loading.value
      }, null, _parent));
      _push(`</aside><div class="md:hidden" data-v-d7d3a4c3><button class="text-xl" data-v-d7d3a4c3><i class="fas fa-sliders-h" data-v-d7d3a4c3></i></button>`);
      _push(ssrRenderComponent(MobileFilterDrawer, {
        filters: filters.value,
        brands: brands.value,
        modelValue: selectedFilters.value,
        "onUpdate:modelValue": ($event) => selectedFilters.value = $event,
        loading: loading.value,
        show: showMobileFilters.value,
        onClose: ($event) => showMobileFilters.value = false
      }, null, _parent));
      _push(`</div><div data-v-d7d3a4c3><div class="flex justify-between items-center mb-4" data-v-d7d3a4c3><div class="relative inline-block w-48" data-v-d7d3a4c3><select class="p-2 pr-8 pl-3 border rounded w-full appearance-none focus:outline-none focus:border-gray-100 border-gray-300 focus:ring-1 focus:ring-gray-200 transition duration-200" dir="rtl" data-v-d7d3a4c3><option value="latest" data-v-d7d3a4c3${ssrIncludeBooleanAttr(Array.isArray(sortBy.value) ? ssrLooseContain(sortBy.value, "latest") : ssrLooseEqual(sortBy.value, "latest")) ? " selected" : ""}>جدیدترین</option><option value="expensive" data-v-d7d3a4c3${ssrIncludeBooleanAttr(Array.isArray(sortBy.value) ? ssrLooseContain(sortBy.value, "expensive") : ssrLooseEqual(sortBy.value, "expensive")) ? " selected" : ""}>بیشترین قیمت</option><option value="cheap" data-v-d7d3a4c3${ssrIncludeBooleanAttr(Array.isArray(sortBy.value) ? ssrLooseContain(sortBy.value, "cheap") : ssrLooseEqual(sortBy.value, "cheap")) ? " selected" : ""}>کمترین قیمت</option><option value="popular" data-v-d7d3a4c3${ssrIncludeBooleanAttr(Array.isArray(sortBy.value) ? ssrLooseContain(sortBy.value, "popular") : ssrLooseEqual(sortBy.value, "popular")) ? " selected" : ""}>محبوب‌ترین</option></select></div></div><div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2" data-v-d7d3a4c3><!--[-->`);
      ssrRenderList(products.value, (product) => {
        _push(ssrRenderComponent(ProductCard, {
          key: product.id,
          product
        }, null, _parent));
      });
      _push(`<!--]--></div>`);
      if (loading.value) {
        _push(`<div class="flex flex-col items-center justify-center py-6" data-v-d7d3a4c3><div class="loader mb-3" data-v-d7d3a4c3></div><p class="text-gray-600 text-sm" data-v-d7d3a4c3>در حال بارگذاری، لطفاً صبور باشید...</p></div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div></div><!--]-->`);
    };
  }
};
const _sfc_setup$n = _sfc_main$n.setup;
_sfc_main$n.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/category/CategoryProducts.vue");
  return _sfc_setup$n ? _sfc_setup$n(props, ctx) : void 0;
};
const CategoryProducts = /* @__PURE__ */ _export_sfc(_sfc_main$n, [["__scopeId", "data-v-d7d3a4c3"]]);
const __vite_glob_0_1 = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: CategoryProducts
}, Symbol.toStringTag, { value: "Module" }));
const _sfc_main$m = {
  __name: "category",
  __ssrInlineRender: true,
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<section${ssrRenderAttrs(_attrs)}>`);
      _push(ssrRenderComponent(CategoryProducts, null, null, _parent));
      _push(`</section>`);
    };
  }
};
const _sfc_setup$m = _sfc_main$m.setup;
_sfc_main$m.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/category.vue");
  return _sfc_setup$m ? _sfc_setup$m(props, ctx) : void 0;
};
const __vite_glob_0_0 = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: _sfc_main$m
}, Symbol.toStringTag, { value: "Module" }));
const _sfc_main$l = {
  __name: "Carousel",
  __ssrInlineRender: true,
  props: {
    images: {
      type: Array,
      required: true
    }
  },
  setup(__props) {
    const renderBullet = (index, className) => {
      return `<button class="${className} w-3 h-2 px-3 mx-2 rounded-full transition-all"></button>`;
    };
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "relative w-full lg:w-1/2 sm:h-60 md:h-full overflow-hidden rounded-xl" }, _attrs))} data-v-f5ba40ad>`);
      _push(ssrRenderComponent(unref(Swiper), {
        modules: [unref(Autoplay), unref(Pagination)],
        "slides-per-view": 1,
        loop: true,
        autoplay: { delay: 5e3 },
        pagination: { el: ".custom-pagination", clickable: true, renderBullet },
        class: "h-full"
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<!--[-->`);
            ssrRenderList(__props.images, (image, index) => {
              _push2(ssrRenderComponent(unref(SwiperSlide), { key: index }, {
                default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                  if (_push3) {
                    _push3(`<div class="slide w-full flex-shrink-0 flex items-center justify-center h-full" data-v-f5ba40ad${_scopeId2}><a${ssrRenderAttr("href", image.link || "#")} data-v-f5ba40ad${_scopeId2}><img${ssrRenderAttr("src", image.src)} loading="lazy" class="w-full h-full object-fill object-center"${ssrRenderAttr("alt", `Slide ${index}`)} data-v-f5ba40ad${_scopeId2}></a></div>`);
                  } else {
                    return [
                      createVNode("div", { class: "slide w-full flex-shrink-0 flex items-center justify-center h-full" }, [
                        createVNode("a", {
                          href: image.link || "#"
                        }, [
                          createVNode("img", {
                            src: image.src,
                            loading: "lazy",
                            class: "w-full h-full object-fill object-center",
                            alt: `Slide ${index}`
                          }, null, 8, ["src", "alt"])
                        ], 8, ["href"])
                      ])
                    ];
                  }
                }),
                _: 2
              }, _parent2, _scopeId));
            });
            _push2(`<!--]-->`);
          } else {
            return [
              (openBlock(true), createBlock(Fragment, null, renderList(__props.images, (image, index) => {
                return openBlock(), createBlock(unref(SwiperSlide), { key: index }, {
                  default: withCtx(() => [
                    createVNode("div", { class: "slide w-full flex-shrink-0 flex items-center justify-center h-full" }, [
                      createVNode("a", {
                        href: image.link || "#"
                      }, [
                        createVNode("img", {
                          src: image.src,
                          loading: "lazy",
                          class: "w-full h-full object-fill object-center",
                          alt: `Slide ${index}`
                        }, null, 8, ["src", "alt"])
                      ], 8, ["href"])
                    ])
                  ]),
                  _: 2
                }, 1024);
              }), 128))
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`<div class="custom-pagination absolute bottom-2 left-1/2 transform -translate-x-1/2 flex space-x-2 z-10" data-v-f5ba40ad></div></div>`);
    };
  }
};
const _sfc_setup$l = _sfc_main$l.setup;
_sfc_main$l.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/home/Carousel.vue");
  return _sfc_setup$l ? _sfc_setup$l(props, ctx) : void 0;
};
const Carousel = /* @__PURE__ */ _export_sfc(_sfc_main$l, [["__scopeId", "data-v-f5ba40ad"]]);
const _imports_0$2 = "/build/assets/banner%20wide2-K9035tmR.png";
const _sfc_main$k = {};
function _sfc_ssrRender$1(_ctx, _push, _parent, _attrs) {
  _push(`<div${ssrRenderAttrs(mergeProps({ class: "w-full h-1/2 lg:h-1/2 px-2 py-1" }, _attrs))}><a href="#" class="block w-full h-full rounded-md overflow-hidden"><img loading="lazy"${ssrRenderAttr("src", _imports_0$2)} class="w-full h-full object-fill rounded-md" alt=""></a></div>`);
}
const _sfc_setup$k = _sfc_main$k.setup;
_sfc_main$k.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/home/bigBanner.vue");
  return _sfc_setup$k ? _sfc_setup$k(props, ctx) : void 0;
};
const bigBanner = /* @__PURE__ */ _export_sfc(_sfc_main$k, [["ssrRender", _sfc_ssrRender$1]]);
const _imports_0$1 = "/build/assets/banner-B-rXBRop.png";
const _sfc_main$j = {};
function _sfc_ssrRender(_ctx, _push, _parent, _attrs) {
  _push(`<div${ssrRenderAttrs(mergeProps({ class: "w-1/2 lg:w-1/2 h-1/2 p-2 mt-2 md:mt-0" }, _attrs))}><a href="#" class="block w-full h-full rounded-md overflow-hidden"><img loading="lazy"${ssrRenderAttr("src", _imports_0$1)} class="w-full h-full object-fill rounded-md" alt=""></a></div>`);
}
const _sfc_setup$j = _sfc_main$j.setup;
_sfc_main$j.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/home/banner.vue");
  return _sfc_setup$j ? _sfc_setup$j(props, ctx) : void 0;
};
const banner = /* @__PURE__ */ _export_sfc(_sfc_main$j, [["ssrRender", _sfc_ssrRender]]);
const _sfc_main$i = {
  __name: "row",
  __ssrInlineRender: true,
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "w-full lg:w-1/2 flex flex-wrap" }, _attrs))}>`);
      _push(ssrRenderComponent(bigBanner, null, null, _parent));
      _push(ssrRenderComponent(banner, null, null, _parent));
      _push(ssrRenderComponent(banner, null, null, _parent));
      _push(`</div>`);
    };
  }
};
const _sfc_setup$i = _sfc_main$i.setup;
_sfc_main$i.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/home/row.vue");
  return _sfc_setup$i ? _sfc_setup$i(props, ctx) : void 0;
};
const _sfc_main$h = {
  __name: "ItemCarousel",
  __ssrInlineRender: true,
  props: {
    product: {
      type: Object,
      required: true
    }
  },
  setup(__props) {
    const props = __props;
    let mainImage = "";
    try {
      const images = JSON.parse(props.product.images || "{}");
      mainImage = images.main || "";
    } catch (e) {
      console.warn("Invalid images JSON", e);
    }
    const discountPercent = computed(() => {
      const { price, discount_price } = props.product;
      if (discount_price && price) {
        return Math.round((price - discount_price) / price * 100);
      }
      return 0;
    });
    const formatPrice = (val) => {
      return new Intl.NumberFormat("fa-IR").format(val);
    };
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "flex flex-col h-full border-2 hover:border-blue-500 border-white rounded-md overflow-hidden" }, _attrs))}>`);
      _push(ssrRenderComponent(unref(Link), {
        href: `/product/${__props.product.slug}`
      }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<div class="w-full aspect-[3/4] overflow-hidden"${_scopeId}><img${ssrRenderAttr("src", `/storage/images/products/${unref(mainImage)}`)}${ssrRenderAttr("alt", __props.product.name)} loading="lazy" class="w-full h-full object-cover rounded object-center"${_scopeId}></div>`);
          } else {
            return [
              createVNode("div", { class: "w-full aspect-[3/4] overflow-hidden" }, [
                createVNode("img", {
                  src: `/storage/images/products/${unref(mainImage)}`,
                  alt: __props.product.name,
                  loading: "lazy",
                  class: "w-full h-full object-cover rounded object-center"
                }, null, 8, ["src", "alt"])
              ])
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`<div class="flex flex-col justify-between flex-1 p-2 space-y-2"><div class="text-center text-xs font-semibold leading-tight line-clamp-2">${ssrInterpolate(__props.product.name)}</div>`);
      if (__props.product.discount_price != 0) {
        _push(`<div><div class="text-center text-green-600 text-sm font-bold">${ssrInterpolate(formatPrice(__props.product.discount_price))} تومان <span class="text-xs text-red-500"> (${ssrInterpolate(discountPercent.value)}٪ تخفیف) </span></div><div class="text-center line-through text-sm text-gray-500">${ssrInterpolate(formatPrice(__props.product.price))} تومان </div></div>`);
      } else {
        _push(`<div class="text-center text-base text-gray-800">${ssrInterpolate(formatPrice(__props.product.price))} تومان </div>`);
      }
      _push(`</div></div>`);
    };
  }
};
const _sfc_setup$h = _sfc_main$h.setup;
_sfc_main$h.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/home/carousel2/ItemCarousel.vue");
  return _sfc_setup$h ? _sfc_setup$h(props, ctx) : void 0;
};
const _sfc_main$g = {
  __name: "carousel2",
  __ssrInlineRender: true,
  props: {
    products: {
      type: Array,
      required: true
    }
  },
  setup(__props) {
    onMounted(() => {
      new Swiper$1(".Itemcarousel", {
        slidesPerView: 3,
        spaceBetween: 6,
        pagination: {
          el: ".swiper-pagination",
          clickable: true
        },
        breakpoints: {
          300: { slidesPerView: 2 },
          640: { slidesPerView: 2.5 },
          768: { slidesPerView: 3 },
          1024: { slidesPerView: 4 }
        }
      });
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "swiper Itemcarousel" }, _attrs))} data-v-a540ac6c><div class="swiper-wrapper" data-v-a540ac6c><!--[-->`);
      ssrRenderList(__props.products, (product) => {
        _push(`<div class="swiper-slide" data-v-a540ac6c>`);
        _push(ssrRenderComponent(_sfc_main$h, { product }, null, _parent));
        _push(`</div>`);
      });
      _push(`<!--]--></div><div class="swiper-pagination" data-v-a540ac6c></div></div>`);
    };
  }
};
const _sfc_setup$g = _sfc_main$g.setup;
_sfc_main$g.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/home/carousel2/carousel2.vue");
  return _sfc_setup$g ? _sfc_setup$g(props, ctx) : void 0;
};
const Carousel2 = /* @__PURE__ */ _export_sfc(_sfc_main$g, [["__scopeId", "data-v-a540ac6c"]]);
const _sfc_main$f = {
  __name: "home",
  __ssrInlineRender: true,
  setup(__props) {
    const { topDiscountedProducts, topseller, appName, description, csrfToken, currentUrl } = usePage().props;
    const carouselImages = [
      { src: "images/slides/shal.jpg" },
      { src: "images/slides/romanoscarf2.jpg" },
      { src: "images/slides/gemini shal.jpg" },
      { src: "images/slides/scarf.jpg" }
    ];
    const structuredData = {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": appName,
      "url": currentUrl,
      "logo": "/favicon.ico",
      "sameAs": [
        "https://t.me/romanoscarfard",
        "https://www.instagram.com/romanoscarf.ard/"
      ]
    };
    useHead({
      script: [
        {
          type: "application/ld+json",
          innerHTML: JSON.stringify(structuredData)
        }
      ]
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[-->`);
      _push(ssrRenderComponent(unref(Head), null, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<title${_scopeId}>${ssrInterpolate(unref(appName))}</title><meta name="description"${ssrRenderAttr("content", unref(description))}${_scopeId}><meta name="csrf-token"${ssrRenderAttr("content", unref(csrfToken))}${_scopeId}><link rel="icon" href="/favicon.ico" type="image/png"${_scopeId}><link rel="canonical"${ssrRenderAttr("href", unref(currentUrl))}${_scopeId}><meta property="og:type" content="website"${_scopeId}><meta property="og:url"${ssrRenderAttr("content", unref(currentUrl))}${_scopeId}><meta property="og:title"${ssrRenderAttr("content", unref(appName))}${_scopeId}><meta property="og:description"${ssrRenderAttr("content", unref(description))}${_scopeId}><meta property="og:site_name"${ssrRenderAttr("content", unref(appName))}${_scopeId}><meta property="og:locale" content="fa_IR"${_scopeId}><meta name="twitter:card" content="summary_large_image"${_scopeId}><meta name="twitter:title"${ssrRenderAttr("content", unref(appName))}${_scopeId}><meta name="twitter:description"${ssrRenderAttr("content", unref(description))}${_scopeId}>`);
          } else {
            return [
              createVNode("title", null, toDisplayString(unref(appName)), 1),
              createVNode("meta", {
                name: "description",
                content: unref(description)
              }, null, 8, ["content"]),
              createVNode("meta", {
                name: "csrf-token",
                content: unref(csrfToken)
              }, null, 8, ["content"]),
              createVNode("link", {
                rel: "icon",
                href: "/favicon.ico",
                type: "image/png"
              }),
              createVNode("link", {
                rel: "canonical",
                href: unref(currentUrl)
              }, null, 8, ["href"]),
              createVNode("meta", {
                property: "og:type",
                content: "website"
              }),
              createVNode("meta", {
                property: "og:url",
                content: unref(currentUrl)
              }, null, 8, ["content"]),
              createVNode("meta", {
                property: "og:title",
                content: unref(appName)
              }, null, 8, ["content"]),
              createVNode("meta", {
                property: "og:description",
                content: unref(description)
              }, null, 8, ["content"]),
              createVNode("meta", {
                property: "og:site_name",
                content: unref(appName)
              }, null, 8, ["content"]),
              createVNode("meta", {
                property: "og:locale",
                content: "fa_IR"
              }),
              createVNode("meta", {
                name: "twitter:card",
                content: "summary_large_image"
              }),
              createVNode("meta", {
                name: "twitter:title",
                content: unref(appName)
              }, null, 8, ["content"]),
              createVNode("meta", {
                name: "twitter:description",
                content: unref(description)
              }, null, 8, ["content"])
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`<section><div class="flex flex-col md:flex-row w-full md:h-72">`);
      _push(ssrRenderComponent(Carousel, { images: carouselImages }, null, _parent));
      _push(ssrRenderComponent(_sfc_main$i, null, null, _parent));
      _push(`</div><div class="mb-4 mt-8 text-xl"> بیشترین تخفیف ها </div>`);
      _push(ssrRenderComponent(Carousel2, { products: unref(topDiscountedProducts) }, null, _parent));
      _push(`<div class="mb-4 mt-8 text-xl"> بیشترین تخفیف ها </div>`);
      _push(ssrRenderComponent(Carousel2, { products: unref(topseller) }, null, _parent));
      _push(`</section><!--]-->`);
    };
  }
};
const _sfc_setup$f = _sfc_main$f.setup;
_sfc_main$f.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/home.vue");
  return _sfc_setup$f ? _sfc_setup$f(props, ctx) : void 0;
};
const __vite_glob_0_5 = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: _sfc_main$f
}, Symbol.toStringTag, { value: "Module" }));
const _sfc_main$e = {
  __name: "ShareMenu",
  __ssrInlineRender: true,
  setup(__props) {
    const showMenu = ref(false);
    const isMobile = ref(false);
    const url = ref("");
    const menuRef = ref(null);
    const closeMenu = () => {
      showMenu.value = false;
    };
    const checkMobile = () => {
      isMobile.value = window.innerWidth < 768;
    };
    const handleClickOutside = (event) => {
      if (menuRef.value && !menuRef.value.contains(event.target)) {
        closeMenu();
      }
    };
    onMounted(() => {
      url.value = window.location.href;
      checkMobile();
      window.addEventListener("resize", checkMobile);
      document.addEventListener("click", handleClickOutside);
    });
    onUnmounted(() => {
      window.removeEventListener("resize", checkMobile);
      document.removeEventListener("click", handleClickOutside);
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<li${ssrRenderAttrs(mergeProps({
        class: "inline-block mx-1 relative",
        ref_key: "menuRef",
        ref: menuRef
      }, _attrs))} data-v-a340b37e><button class="text-gray-500 hover:text-blue-600" data-v-a340b37e><i class="fa fa-link text-xl" data-v-a340b37e></i></button>`);
      if (showMenu.value && isMobile.value) {
        _push(`<div class="fixed inset-0 bg-black bg-opacity-40 z-40" data-v-a340b37e></div>`);
      } else {
        _push(`<!---->`);
      }
      if (showMenu.value) {
        _push(`<div class="${ssrRenderClass([isMobile.value ? "fixed bottom-4 left-1/2 -translate-x-1/2 w-11/12 max-w-sm p-4 bg-white rounded-xl shadow-xl" : "absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl p-4", "z-50"])}" data-v-a340b37e><p class="text-gray-700 mb-3 text-sm font-semibold text-center" data-v-a340b37e> ارسال از طریق: </p><div class="flex justify-between items-center text-xl" data-v-a340b37e><a${ssrRenderAttr("href", `https://t.me/share/url?url=${url.value}`)} target="_blank" title="تلگرام" class="text-blue-400 hover:text-blue-500" data-v-a340b37e><i class="fab fa-telegram" data-v-a340b37e></i></a><a${ssrRenderAttr("href", `https://wa.me/?text=${url.value}`)} target="_blank" title="واتساپ" class="text-green-500 hover:text-green-600" data-v-a340b37e><i class="fab fa-whatsapp" data-v-a340b37e></i></a><a${ssrRenderAttr("href", `https://www.instagram.com/?url=${url.value}`)} target="_blank" title="اینستاگرام" class="text-pink-500 hover:text-pink-600" data-v-a340b37e><i class="fab fa-instagram" data-v-a340b37e></i></a><a${ssrRenderAttr("href", `sms:?body=${url.value}`)} title="پیامک" class="text-gray-700 hover:text-gray-800" data-v-a340b37e><i class="fa fa-sms" data-v-a340b37e></i></a><button title="کپی لینک" class="text-gray-500 hover:text-blue-600" data-v-a340b37e><i class="fas fa-clipboard" data-v-a340b37e></i></button></div></div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</li>`);
    };
  }
};
const _sfc_setup$e = _sfc_main$e.setup;
_sfc_main$e.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/products/romano/ShareMenu.vue");
  return _sfc_setup$e ? _sfc_setup$e(props, ctx) : void 0;
};
const ShareMenu = /* @__PURE__ */ _export_sfc(_sfc_main$e, [["__scopeId", "data-v-a340b37e"]]);
const _sfc_main$d = {
  __name: "like-share-compare",
  __ssrInlineRender: true,
  props: {
    product: Object
  },
  setup(__props) {
    const props = __props;
    const isLoggedIn = usePage().props.auth.user;
    const like = ref(true);
    const likeFetch = async (product) => {
      if (isLoggedIn != null) {
        try {
          const response = await axios.get(`/api/getlikestatus/${product.id}`);
          like.value = response.data.like;
        } catch (error) {
        }
      }
    };
    onMounted(() => {
      likeFetch(props.product);
    });
    const page = usePage();
    page.url;
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "flex lg:flex-col align-top text-2xl lg:w-1/12" }, _attrs))}><ul class="float-left"><li title="اضافه به علاقه مندی" class="inline-block mx-1 cursor-pointer"><i class="${ssrRenderClass([
        "fa-heart",
        like.value === 1 ? "fa-solid text-red-500" : "fa-regular text-gray-500"
      ])}"></i></li><li class="inline-block mx-1">`);
      _push(ssrRenderComponent(ShareMenu, null, null, _parent));
      _push(`</li><li class="inline-block mx-1"><i class="fa fa-code-compare text-gray-500"></i></li></ul></div>`);
    };
  }
};
const _sfc_setup$d = _sfc_main$d.setup;
_sfc_main$d.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/products/romano/like-share-compare.vue");
  return _sfc_setup$d ? _sfc_setup$d(props, ctx) : void 0;
};
const _sfc_main$c = {
  __name: "ProductGallery",
  __ssrInlineRender: true,
  props: {
    product: Object
  },
  setup(__props) {
    const props = __props;
    const images = computed(() => {
      try {
        return JSON.parse(props.product.images);
      } catch (e) {
        console.error("مشکل در parse تصاویر محصول:", e);
        return { main: "", gallery: [] };
      }
    });
    const selectedImage = ref({
      name: images.value.main,
      fromGallery: false
    });
    const mainImageUrl = computed(() => {
      if (!selectedImage.value.name) return "";
      const base = selectedImage.value.fromGallery ? "/storage/images/products/gallery/" : "/storage/images/products/";
      return base + selectedImage.value.name;
    });
    const modalVisible = ref(false);
    const getImageUrl = (img) => `/storage/images/products/${img}`;
    const getGalleryUrl = (img) => `/storage/images/products/gallery/${img}`;
    const mainImageContainer = ref();
    const mainImageEl = ref();
    onMounted(() => {
      if (mainImageContainer.value && mainImageEl.value) {
        mainImageContainer.value.addEventListener("mousemove", (e) => {
          const rect = mainImageEl.value.getBoundingClientRect();
          const x = (e.clientX - rect.left) / rect.width * 100;
          const y = (e.clientY - rect.top) / rect.height * 100;
          mainImageEl.value.style.transformOrigin = `${x}% ${y}%`;
          mainImageEl.value.style.transform = "scale(2)";
        });
        mainImageContainer.value.addEventListener("mouseleave", () => {
          mainImageEl.value.style.transform = "scale(1)";
        });
      }
      new Swiper$2(".mobilepimage", {
        slidesPerView: 1,
        spaceBetween: 15,
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
          dynamicBullets: true
        },
        autoplay: {
          delay: 3e3,
          disableOnInteraction: false
        },
        on: {
          autoplayTimeLeft(swiper, time, progress) {
            const circle = document.getElementById("progress-circle");
            if (circle) {
              const circumference = 100;
              const offset = circumference * (1 - progress);
              circle.style.strokeDashoffset = offset;
            }
          },
          slideChange() {
            const circle = document.getElementById("progress-circle");
            if (circle) {
              circle.style.transition = "none";
              circle.style.strokeDashoffset = 100;
              setTimeout(() => {
                circle.style.transition = "stroke-dashoffset 0.1s linear";
              }, 50);
            }
          }
        }
      });
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "flex flex-col lg:flex-row w-full md:w-2/4 pb-6" }, _attrs))}>`);
      _push(ssrRenderComponent(_sfc_main$d, { product: __props.product }, null, _parent));
      _push(`<div class="flex flex-col w-full justify-center"><div class="mx-4 rounded-md hidden md:block relative overflow-hidden"><img${ssrRenderAttr("src", mainImageUrl.value)} loading="lazy"${ssrRenderAttr("alt", __props.product.name)} decoding="async" width="350" height="350" class="w-full h-[60vh] transition-transform duration-300 ease-in-out object-scale-down rounded-2xl"></div><div class="md:flex hidden w-full justify-start md:h-1/6 my-4 gap-2"><div class="cursor-pointer border border-gray-50 hover:border-green-300"><img${ssrRenderAttr("src", getImageUrl(images.value.main))} class="w-full md:h-20 lg:h-20"${ssrRenderAttr("alt", "Thumbnail " + images.value.main)}></div><!--[-->`);
      ssrRenderList(images.value.gallery.slice(0, 5), (img, i) => {
        _push(`<div class="cursor-pointer border border-gray-50 aspect-[3/4] hover:border-green-300"><img${ssrRenderAttr("src", getGalleryUrl(img))} class="w-full md:h-20 lg:h-20"${ssrRenderAttr("alt", "Thumbnail " + img)}></div>`);
      });
      _push(`<!--]--><div class="flex justify-center items-center px-2 cursor-pointer"><span class="text-4xl text-gray-500">...</span></div></div>`);
      if (modalVisible.value) {
        _push(`<div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50"><div class="bg-white p-6 rounded-md max-w-4xl w-full relative"><button class="absolute top-2 right-2 text-2xl text-gray-700">×</button><div class="grid grid-cols-3 gap-4"><div class="cursor-pointer border border-gray-50 hover:border-green-300"><img${ssrRenderAttr("src", getImageUrl(images.value.main))} class="w-full"></div><!--[-->`);
        ssrRenderList(images.value.gallery, (img, i) => {
          _push(`<div class="cursor-pointer hover:scale-105 transition-transform duration-200"><img${ssrRenderAttr("src", getGalleryUrl(img))} class="w-full"></div>`);
        });
        _push(`<!--]--></div></div></div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`<div class="md:hidden w-full"><div class="swiper mobilepimage w-full"><div class="swiper-wrapper"><div class="swiper-slide"><img${ssrRenderAttr("src", getImageUrl(images.value.main))} class="w-full max-h-96 object-contain"></div><!--[-->`);
      ssrRenderList(images.value.gallery, (img, i) => {
        _push(`<div class="swiper-slide"><img${ssrRenderAttr("src", getGalleryUrl(img))} class="w-full max-h-96 object-contain"></div>`);
      });
      _push(`<!--]--></div><div class="absolute bottom-2 left-25 transform z-10 -translate-x-1/2" style="${ssrRenderStyle({ "pointer-events": "none" })}"><svg class="w-6 h-6" viewBox="0 0 36 36"><path class="text-gray-300" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845
           a 15.9155 15.9155 0 0 1 0 31.831
           a 15.9155 15.9155 0 0 1 0 -31.831"></path><path id="progress-circle" class="text-blue-500 transition-all duration-100 ease-linear" stroke-width="3" stroke-linecap="round" stroke="currentColor" fill="none" stroke-dasharray="100" stroke-dashoffset="100" d="M18 2.0845
           a 15.9155 15.9155 0 0 1 0 31.831
           a 15.9155 15.9155 0 0 1 0 -31.831"></path></svg></div><div class="swiper-pagination"></div></div></div></div></div>`);
    };
  }
};
const _sfc_setup$c = _sfc_main$c.setup;
_sfc_main$c.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/products/romano/ProductGallery.vue");
  return _sfc_setup$c ? _sfc_setup$c(props, ctx) : void 0;
};
const useCartStore = defineStore("cart", {
  state: () => ({
    items: []
  }),
  getters: {
    total(state) {
      return state.items.reduce((sum, item) => sum + item.price * item.quantity, 0);
    },
    count(state) {
      return state.items.reduce((sum, item) => sum + item.quantity, 0);
    }
  },
  actions: {
    setItems(items) {
      this.items = items || [];
    },
    addLocal(item) {
      const idx = this.items.findIndex((i) => i.id === item.id && i.code === item.code);
      if (idx !== -1) {
        this.items[idx].quantity += item.quantity ?? 1;
      } else {
        this.items.push({ ...item, quantity: item.quantity ?? 1 });
      }
    },
    async increase(id, code) {
      const form = useForm();
      const item = this.items.find((i) => i.id === id && i.code === code);
      if (item) item.quantity++;
      try {
        await form.post(route("cart.increase", id), { data: { code } });
      } catch {
        if (item) item.quantity--;
      }
    },
    async decrease(id, code) {
      const form = useForm();
      const item = this.items.find((i) => i.id === id && i.code === code);
      if (item && item.quantity > 1) item.quantity--;
      try {
        await form.post(route("cart.decrease", id), { data: { code } });
      } catch {
        if (item) item.quantity++;
      }
    },
    async remove(id, code) {
      const form = useForm();
      const index = this.items.findIndex((i) => i.id === id && i.code === code);
      let removedItem = null;
      if (index !== -1) removedItem = this.items.splice(index, 1)[0];
      try {
        await form.delete(route("cart.remove", id), { data: { code } });
      } catch {
        if (removedItem) this.items.splice(index, 0, removedItem);
      }
    },
    async clear() {
      const form = useForm();
      const oldItems = [...this.items];
      this.items = [];
      try {
        await form.post(route("cart.clear"));
      } catch {
        this.items = oldItems;
      }
    }
  }
});
const _sfc_main$b = {
  __name: "ProductInfo",
  __ssrInlineRender: true,
  props: {
    product: Object
  },
  setup(__props) {
    const props = __props;
    usePage();
    useCartStore();
    const attributes = computed(() => {
      if (!props.product.attributes) return [];
      return typeof props.product.attributes === "string" ? JSON.parse(props.product.attributes) : props.product.attributes;
    });
    const codes = computed(() => {
      if (!props.product.code) return [];
      try {
        return JSON.parse(props.product.code);
      } catch (e) {
        console.error("خطا در parse کردن code:", e);
        return [];
      }
    });
    const selectedCode = ref("");
    const successMessage = ref("");
    const finalPrice = computed(() => {
      const discount = Number(props.product.discount_price);
      const price = Number(props.product.price);
      if (discount && discount > 0) {
        return discount;
      }
      return price;
    });
    const hasDiscount = computed(() => {
      const discount = Number(props.product.discount_price);
      return discount && discount > 0;
    });
    const discountPercent = computed(
      () => Math.round(
        (props.product.price - props.product.discount_price) / props.product.price * 100
      )
    );
    const formatNumber = (number) => new Intl.NumberFormat("fa-IR").format(Number(number));
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "flex pr-8 pt-4 flex-col md:w-2/4 w-full" }, _attrs))}><div class="pt-4 pb-2"><h1 class="text-gray-600 text-3xl md:xl font-bold">${ssrInterpolate(__props.product.name)}</h1></div><ul class="space-y-1 text-sm mb-4"><!--[-->`);
      ssrRenderList(attributes.value, (attr, index) => {
        _push(`<li><span class="text-gray-500">${ssrInterpolate(attr.name)}:</span> ${ssrInterpolate(attr.value)}</li>`);
      });
      _push(`<!--]--></ul><div class="w-full border-t border-dashed border-gray-300 my-4"></div><div class="w-full py-2" id="codeMessage"><h3 class="text-gray-700 mb-2 text-sm font-semibold">انتخاب طرح:</h3><div class="flex flex-wrap gap-2"><!--[-->`);
      ssrRenderList(codes.value, (item, index) => {
        _push(`<button class="flex items-center justify-center px-4 py-2 rounded-md text-sm font-semibold transition-all border" style="${ssrRenderStyle({
          backgroundColor: item.color,
          color: "#fff",
          borderColor: selectedCode.value === item.label ? "#10b981" : "transparent",
          boxShadow: selectedCode.value === item.label ? "0 0 0 2px #10b981" : "none"
        })}">${ssrInterpolate(item.label || "بدون نام")}</button>`);
      });
      _push(`<!--]--></div>`);
      if (selectedCode.value) {
        _push(`<div class="mt-3 text-green-600 text-sm font-medium"> طرح انتخاب‌شده: ${ssrInterpolate(selectedCode.value)}</div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div><div class="w-full px-2 mt-6">`);
      if (hasDiscount.value) {
        _push(`<div class="hidden md:block text-sm md:py-2 text-center"><span class="line-through mx-4">${ssrInterpolate(formatNumber(__props.product.price))} تومان</span><span class="rounded-lg bg-red-500 px-2 text-white">${ssrInterpolate(discountPercent.value)}% </span></div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`<div class="hidden md:block text-2xl md:py-2 text-center"><span>${ssrInterpolate(formatNumber(finalPrice.value))} <span class="text-sm">تومان</span></span></div><div class="fixed bottom-2 right-0 z-10 w-full px-2 md:static md:px-0"><button class="flex justify-between items-center text-center my-2 py-2 border rounded-lg lg:w-1/2 lg:mx-auto w-full bg-green-600 text-white"><div class="md:hidden mx-auto flex-col text-center">`);
      if (hasDiscount.value) {
        _push(`<div><span class="rounded-lg text-sm bg-red-500 px-1">${ssrInterpolate(discountPercent.value)}% </span><span class="line-through text-sm px-2">${ssrInterpolate(formatNumber(__props.product.price))} تومان</span></div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`<div><span class="text-xl">${ssrInterpolate(formatNumber(finalPrice.value))} تومان</span></div></div><svg width="30" height="30" class="md:hidden mx-2" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="15" cy="15" r="14.5" stroke="white"></circle><line x1="15" y1="7.1" x2="15" y2="22.9" stroke="white" stroke-width="2"></line><line x1="7.132" y1="14.966" x2="22.868" y2="15.034" stroke="white" stroke-width="2"></line></svg><span class="hidden md:block mx-auto">افزودن سبد خرید</span></button></div>`);
      if (successMessage.value) {
        _push(`<div class="text-green-600 text-sm mt-2 text-center">${ssrInterpolate(successMessage.value)}</div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div></div>`);
    };
  }
};
const _sfc_setup$b = _sfc_main$b.setup;
_sfc_main$b.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/products/romano/ProductInfo.vue");
  return _sfc_setup$b ? _sfc_setup$b(props, ctx) : void 0;
};
const _sfc_main$a = {
  __name: "ItemCard",
  __ssrInlineRender: true,
  props: {
    product: Object
  },
  setup(__props) {
    const props = __props;
    const mainImage = computed(() => {
      try {
        const images = JSON.parse(props.product.images || "{}");
        return images.main || "";
      } catch {
        return "";
      }
    });
    const discountPercent = computed(() => {
      const { price, discount_price } = props.product;
      return Math.round((price - discount_price) / price * 100);
    });
    function numberFormat(num) {
      return new Intl.NumberFormat("fa-IR").format(num);
    }
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "flex flex-col h-full border-2 hover:border-blue-500 border-white rounded-md overflow-hidden" }, _attrs))}><a${ssrRenderAttr("href", `/product/${__props.product.slug}`)}><div class="w-full aspect-[3/4] overflow-hidden"><img${ssrRenderAttr("src", `/storage/images/products/${mainImage.value}`)}${ssrRenderAttr("alt", __props.product.name)} loading="lazy" class="w-full h-full object-cover rounded object-center"></div></a><div class="flex flex-col justify-between flex-1 p-2 space-y-2"><div class="text-center text-xs font-semibold leading-tight line-clamp-2">${ssrInterpolate(__props.product.name)}</div>`);
      if (__props.product.discount_price && __props.product.discount_price != 0) {
        _push(`<!--[--><div class="text-center text-green-600 text-sm font-bold">${ssrInterpolate(numberFormat(__props.product.discount_price))} تومان <span class="text-xs text-red-500"> (${ssrInterpolate(discountPercent.value)}٪ تخفیف) </span></div><div class="text-center line-through text-sm text-gray-500">${ssrInterpolate(numberFormat(__props.product.price))} تومان </div><!--]-->`);
      } else {
        _push(`<div class="text-center text-base text-gray-800">${ssrInterpolate(numberFormat(__props.product.price))} تومان </div>`);
      }
      _push(`</div></div>`);
    };
  }
};
const _sfc_setup$a = _sfc_main$a.setup;
_sfc_main$a.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/products/romano/ItemCard.vue");
  return _sfc_setup$a ? _sfc_setup$a(props, ctx) : void 0;
};
const _sfc_main$9 = {
  __name: "sameProduct",
  __ssrInlineRender: true,
  setup(__props) {
    const products = ref([]);
    products.value = usePage().props.related;
    return (_ctx, _push, _parent, _attrs) => {
      if (products.value.length) {
        _push(`<div${ssrRenderAttrs(mergeProps({ class: "my-8" }, _attrs))} data-v-cc533413><h2 class="text-xl font-bold text-center mb-4" data-v-cc533413>محصولات مشابه</h2>`);
        _push(ssrRenderComponent(unref(Swiper), {
          "slides-per-view": 2,
          "space-between": 10,
          pagination: { clickable: true },
          breakpoints: {
            640: { slidesPerView: 2.5 },
            768: { slidesPerView: 3.5 },
            1024: { slidesPerView: 4.5 }
          }
        }, {
          pagination: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) ;
            else {
              return [];
            }
          }),
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(`<!--[-->`);
              ssrRenderList(products.value, (product) => {
                _push2(ssrRenderComponent(unref(SwiperSlide), {
                  key: product.id
                }, {
                  default: withCtx((_2, _push3, _parent3, _scopeId2) => {
                    if (_push3) {
                      _push3(ssrRenderComponent(_sfc_main$a, { product }, null, _parent3, _scopeId2));
                    } else {
                      return [
                        createVNode(_sfc_main$a, { product }, null, 8, ["product"])
                      ];
                    }
                  }),
                  _: 2
                }, _parent2, _scopeId));
              });
              _push2(`<!--]-->`);
            } else {
              return [
                (openBlock(true), createBlock(Fragment, null, renderList(products.value, (product) => {
                  return openBlock(), createBlock(unref(SwiperSlide), {
                    key: product.id
                  }, {
                    default: withCtx(() => [
                      createVNode(_sfc_main$a, { product }, null, 8, ["product"])
                    ]),
                    _: 2
                  }, 1024);
                }), 128))
              ];
            }
          }),
          _: 1
        }, _parent));
        _push(`</div>`);
      } else {
        _push(`<!---->`);
      }
    };
  }
};
const _sfc_setup$9 = _sfc_main$9.setup;
_sfc_main$9.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/products/romano/sameProduct.vue");
  return _sfc_setup$9 ? _sfc_setup$9(props, ctx) : void 0;
};
const SameProduct = /* @__PURE__ */ _export_sfc(_sfc_main$9, [["__scopeId", "data-v-cc533413"]]);
const _sfc_main$8 = {
  __name: "romanoProductPage",
  __ssrInlineRender: true,
  props: {
    product: Object
  },
  setup(__props) {
    const breadcrumb = ref([]);
    breadcrumb.value = usePage().props.categories;
    onMounted(() => {
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[--><div class="text-sm text-gray-500 flex flex-wrap gap-1 pb-3 rtl:flex-row-reverse"><a href="/">فروشگاه اینترنتی</a><!--[-->`);
      ssrRenderList(breadcrumb.value, (cat) => {
        _push(`<!--[--><span>/</span><a${ssrRenderAttr("href", `/category/${cat.slug}`)} class="hover:text-green-600 transition">${ssrInterpolate(cat.name)}</a><!--]-->`);
      });
      _push(`<!--]--></div><div class="flex max-md:flex-col">`);
      _push(ssrRenderComponent(_sfc_main$c, { product: __props.product }, null, _parent));
      _push(ssrRenderComponent(_sfc_main$b, { product: __props.product }, null, _parent));
      _push(`</div><div class="pt-2 pb-4 w-full">${__props.product.description ?? ""}</div>`);
      _push(ssrRenderComponent(SameProduct, null, null, _parent));
      _push(`<!--]-->`);
    };
  }
};
const _sfc_setup$8 = _sfc_main$8.setup;
_sfc_main$8.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/products/romano/romanoProductPage.vue");
  return _sfc_setup$8 ? _sfc_setup$8(props, ctx) : void 0;
};
const _sfc_main$7 = {
  __name: "product",
  __ssrInlineRender: true,
  setup(__props) {
    const { appName } = usePage().props;
    const { csrfToken, currentUrl, siteUrl } = usePage().props;
    const productprops = usePage().props.product;
    const productMainImage = computed(() => {
      try {
        const images = JSON.parse(productprops.images);
        return images.main;
      } catch (e) {
        console.error("Failed to parse product images JSON:", e);
        return "";
      }
    });
    const isDiscounted = productprops.discount_price > 0;
    const finalprice = isDiscounted ? productprops.discount_price : productprops.price;
    const availabilityStatus = productprops.stock > 0 ? "https://schema.org/InStock" : "https://schema.org/OutOfStock";
    const structuredData = {
      "@context": "https://schema.org",
      "@type": "Product",
      "name": productprops.name,
      "image": [`${siteUrl}/storage/images/products/${productMainImage.value}`],
      "description": productprops.seo_description,
      "offers": {
        "@type": "Offer",
        "price": finalprice * 10,
        "priceCurrency": "IRR",
        "availability": availabilityStatus
      }
    };
    useHead({
      script: [
        {
          type: "application/ld+json",
          innerHTML: JSON.stringify(structuredData)
        }
      ]
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<!--[--><head><title>${ssrInterpolate(unref(productprops).name)}</title><meta name="description"${ssrRenderAttr("content", unref(productprops).seo_description)}><meta name="csrf-token"${ssrRenderAttr("content", unref(csrfToken))}><meta property="og:type" content="product"><meta property="og:url" content="{{ currentUrl }}"><meta property="og:title" content="{{ productprops.name }}"><meta property="og:description" content="{{ productprops.seo_description }}"><meta property="og:image"${ssrRenderAttr("content", `${unref(siteUrl)}/storage/images/products/${productMainImage.value.value}`)}><meta property="twitter:card" content="summary_large_image"><meta property="twitter:title" content="{{ productprops.name }}"><meta property="twitter:description" content="{{productprops.seo_description}}"><meta property="twitter:image"${ssrRenderAttr("content", `${unref(siteUrl)}/storage/images/products/${productMainImage.value.value}`)}></head><section>`);
      _push(ssrRenderComponent(_sfc_main$8, { product: unref(productprops) }, null, _parent));
      _push(`</section><!--]-->`);
    };
  }
};
const _sfc_setup$7 = _sfc_main$7.setup;
_sfc_main$7.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Pages/product.vue");
  return _sfc_setup$7 ? _sfc_setup$7(props, ctx) : void 0;
};
const __vite_glob_0_6 = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: _sfc_main$7
}, Symbol.toStringTag, { value: "Module" }));
const _imports_0 = "/build/assets/romanologo-DVX-dr9G.jpg";
const _imports_1$1 = "/build/assets/search%20icon-Cu7ZuIl3.svg";
const _sfc_main$6 = {
  __name: "search",
  __ssrInlineRender: true,
  setup(__props) {
    const search = ref("");
    const results = ref([]);
    const showDropdown = ref(false);
    debounce(async () => {
      if (!search.value.trim()) {
        results.value = [];
        showDropdown.value = false;
        return;
      }
      try {
        const response = await axios.get(`/products/search?q=${search.value}`);
        results.value = response.data;
        showDropdown.value = true;
      } catch (error) {
        console.error(error);
      }
    }, 500);
    const getThumb = (images) => {
      if (!images) return "";
      if (typeof images === "string") {
        try {
          const obj = JSON.parse(images);
          return obj.thumb || "";
        } catch {
          return "";
        }
      }
      return images.thumb || "";
    };
    const formatPrice = (price) => {
      return new Intl.NumberFormat("fa-IR", {
        maximumFractionDigits: 0
      }).format(price) + " تومان";
    };
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "relative w-full mx-auto" }, _attrs))}><input${ssrRenderAttr("value", search.value)} type="text" placeholder="جستجوی محصول..." class="border border-gray-300 rounded-lg p-2 w-full focus:border-gray-100 focus:ring-1 focus:ring-gray-200 focus:outline-none transition duration-200">`);
      if (results.value.length && showDropdown.value) {
        _push(`<div class="absolute left-0 right-0 bg-white shadow-lg rounded-lg z-50 mt-2 max-h-60 overflow-auto"><ul><!--[-->`);
        ssrRenderList(results.value, (item) => {
          _push(`<li class="p-3 hover:bg-gray-100 cursor-pointer flex items-center gap-2"><a${ssrRenderAttr("href", `/product/${item.slug}`)}><img${ssrRenderAttr("src", `/storage/images/products/thumb/${getThumb(item.images)}`)} alt="" class="w-10 h-10 object-cover rounded-md"><div class="flex-1"><p class="font-semibold text-sm">${ssrInterpolate(item.name)}</p>`);
          if (Number(item.discount_price) === 0) {
            _push(`<p class="text-xs text-gray-500">${ssrInterpolate(formatPrice(item.price))}</p>`);
          } else {
            _push(`<p class="text-xs text-gray-500">${ssrInterpolate(formatPrice(item.discount_price))}</p>`);
          }
          _push(`</div></a></li>`);
        });
        _push(`<!--]--></ul></div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div>`);
    };
  }
};
const _sfc_setup$6 = _sfc_main$6.setup;
_sfc_main$6.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/products/search.vue");
  return _sfc_setup$6 ? _sfc_setup$6(props, ctx) : void 0;
};
const _sfc_main$5 = {
  __name: "Cart",
  __ssrInlineRender: true,
  setup(__props) {
    const cartStore = useCartStore();
    const page = usePage();
    watch(
      () => {
        var _a;
        return (_a = page.props.cart) == null ? void 0 : _a.items;
      },
      (newItems) => {
        if (Array.isArray(newItems)) cartStore.setItems(newItems);
      },
      { immediate: true, deep: true }
    );
    cartStore.items = cartStore.items.map((item) => ({
      ...item,
      images: JSON.parse(item.images)
    }));
    return (_ctx, _push, _parent, _attrs) => {
      if (unref(cartStore).items.length > 0) {
        _push(`<div${ssrRenderAttrs(_attrs)}><!--[-->`);
        ssrRenderList(unref(cartStore).items, (item) => {
          _push(`<div class="flex justify-between gap-3 mb-4 border-b pb-2"><img${ssrRenderAttr("src", `/storage/images/products/thumb/${item.images.thumb}`)}${ssrRenderAttr("alt", item.name)} class="w-16 h-16 rounded object-cover"> <div class="flex-grow justify-between"><h4 class="font-semibold">${ssrInterpolate(item.name)}</h4><p>طرح: ${ssrInterpolate(item.code)}</p><p class="text-sm text-gray-600">${ssrInterpolate(item.price.toLocaleString())} تومان</p></div><div class="flex items-center mt-2 gap-2"><button class="px-2 border">−</button><span class="text-sm">${ssrInterpolate(item.quantity)}</span><button class="px-2 border">+</button><button class="text-red-500 text-lg hover:text-red-700 ml-2" title="حذف">🗑</button></div></div>`);
        });
        _push(`<!--]--><div class="flex justify-between items-center mt-4 font-bold"><span>جمع کل:</span><span>${ssrInterpolate(unref(cartStore).total.toLocaleString())} تومان</span></div><div class="flex justify-between mt-4"><button class="bg-red-500 px-2 text-center text-white py-2 rounded hover:bg-red-600">پاکسازی سبد خرید</button><a href="/cart" class="px-2 bg-green-400 text-center text-white py-2 rounded hover:bg-green-600">ثبت سفارش</a></div></div>`);
      } else {
        _push(`<p${ssrRenderAttrs(mergeProps({ class: "text-center text-gray-500 mt-4" }, _attrs))}>سبد خرید خالی است</p>`);
      }
    };
  }
};
const _sfc_setup$5 = _sfc_main$5.setup;
_sfc_main$5.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/header/Cart.vue");
  return _sfc_setup$5 ? _sfc_setup$5(props, ctx) : void 0;
};
const _sfc_main$4 = {
  __name: "Navbar",
  __ssrInlineRender: true,
  setup(__props) {
    const { parents = [], children = [] } = usePage().props.navbarcategories ?? {};
    const showMobileMenu = ref(false);
    const showMegaMenu = ref(false);
    const activeSubmenuId = ref(null);
    ref(false);
    const showChildrenMobile = ref({});
    function childrenOf(parentId) {
      return children.filter((c) => c.parent_id === parentId);
    }
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<nav${ssrRenderAttrs(mergeProps({ class: "px-4 relative" }, _attrs))} data-v-60754ae6><div class="mx-auto flex items-center justify-between" data-v-60754ae6><button class="sm:hidden text-xl" data-v-60754ae6><i class="fa fa-bars" data-v-60754ae6></i></button><div class="hidden sm:flex gap-6 items-center" data-v-60754ae6><div class="relative" data-v-60754ae6><div style="${ssrRenderStyle(showMegaMenu.value ? null : { display: "none" })}" class="absolute right-0 top-10 z-50 bg-gray-100 shadow-lg w-[600px] p-6 rounded-md flex gap-8" data-v-60754ae6><div class="w-1/3" data-v-60754ae6><ul data-v-60754ae6><!--[-->`);
      ssrRenderList(unref(parents), (parent) => {
        _push(`<li class="py-2 hover:text-green-700 cursor-pointer" data-v-60754ae6>${ssrInterpolate(parent.name)}</li>`);
      });
      _push(`<!--]--></ul></div><div class="w-2/3" data-v-60754ae6><!--[-->`);
      ssrRenderList(unref(parents), (parent) => {
        _push(`<div style="${ssrRenderStyle(activeSubmenuId.value === parent.id ? null : { display: "none" })}" data-v-60754ae6><ul data-v-60754ae6><!--[-->`);
        ssrRenderList(unref(children).filter((c) => c.parent_id === parent.id), (child) => {
          _push(`<li class="py-2 hover:text-green-700" data-v-60754ae6><a${ssrRenderAttr("href", `/category/${child.slug}`)} data-v-60754ae6>${ssrInterpolate(child.name)}</a></li>`);
        });
        _push(`<!--]--></ul></div>`);
      });
      _push(`<!--]--></div></div></div><!--[-->`);
      ssrRenderList(unref(parents), (parent) => {
        _push(`<div data-v-60754ae6><a${ssrRenderAttr("href", `/category/${parent.slug}`)} class="hover:text-green-600" data-v-60754ae6>${ssrInterpolate(parent.name)}</a></div>`);
      });
      _push(`<!--]--><button class="max-sm:hidden mx-2 py-2 hover:text-green-600" data-v-60754ae6><i class="fa-solid fa-file-lines pl-4" data-v-60754ae6><span class="px-2 font-thin" data-v-60754ae6><a href="/blog" data-v-60754ae6>بلاگ</a></span></i></button> <a href="/about" class="hover:text-green-600" data-v-60754ae6>درباره ما</a><a href="/contact" class="hover:text-green-600" data-v-60754ae6>تماس با ما</a></div></div>`);
      if (showMobileMenu.value) {
        _push(`<div class="fixed top-0 right-0 z-50 h-full w-2/3 md:w-2/3 bg-white shadow-lg p-4" data-v-60754ae6><div class="flex justify-between items-center border-b pb-2 mb-4" data-v-60754ae6><span class="text-lg font-bold" data-v-60754ae6>منو</span><button class="text-xl" data-v-60754ae6>×</button></div><ul data-v-60754ae6><li class="mb-2" data-v-60754ae6><a href="/" class="block p-2 hover:bg-gray-100" data-v-60754ae6>خانه</a></li><!--[-->`);
        ssrRenderList(unref(parents), (parent) => {
          _push(`<li class="mb-2 border-b pb-2" data-v-60754ae6><div class="flex justify-between items-center p-2 hover:bg-gray-100 cursor-pointer" data-v-60754ae6><a${ssrRenderAttr("href", `/category/${parent.slug}`)} data-v-60754ae6>${ssrInterpolate(parent.name)}</a>`);
          if (childrenOf(parent.id).length) {
            _push(`<i class="${ssrRenderClass([
              "transition-transform duration-300",
              showChildrenMobile.value[parent.id] ? "fa fa-chevron-up" : "fa fa-chevron-down"
            ])}" data-v-60754ae6></i>`);
          } else {
            _push(`<!---->`);
          }
          _push(`</div><ul style="${ssrRenderStyle(showChildrenMobile.value[parent.id] ? null : { display: "none" })}" class="pl-4" data-v-60754ae6><!--[-->`);
          ssrRenderList(childrenOf(parent.id), (child) => {
            _push(`<li class="p-2 hover:bg-gray-50" data-v-60754ae6><a${ssrRenderAttr("href", `/category/${child.slug}`)} data-v-60754ae6>${ssrInterpolate(child.name)}</a></li>`);
          });
          _push(`<!--]--></ul></li>`);
        });
        _push(`<!--]--><li class="mb-2" data-v-60754ae6><a href="/blog" class="block p-2 hover:bg-gray-100" data-v-60754ae6>بلاگ</a></li><li class="mb-2" data-v-60754ae6><a href="/about" class="block p-2 hover:bg-gray-100" data-v-60754ae6>درباره ما</a></li><li class="mb-2" data-v-60754ae6><a href="/contact" class="block p-2 hover:bg-gray-100" data-v-60754ae6>تماس با ما</a></li></ul></div>`);
      } else {
        _push(`<!---->`);
      }
      if (showMobileMenu.value) {
        _push(`<div class="fixed inset-0 bg-black bg-opacity-40 z-40" data-v-60754ae6></div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</nav>`);
    };
  }
};
const _sfc_setup$4 = _sfc_main$4.setup;
_sfc_main$4.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/header/Navbar.vue");
  return _sfc_setup$4 ? _sfc_setup$4(props, ctx) : void 0;
};
const Navbar = /* @__PURE__ */ _export_sfc(_sfc_main$4, [["__scopeId", "data-v-60754ae6"]]);
const _sfc_main$3 = {
  __name: "User",
  __ssrInlineRender: true,
  props: {
    user: { type: Object, default: null }
  },
  setup(__props) {
    const page = usePage();
    const props = __props;
    const showUserInfo = ref(false);
    const showLoginModal = ref(false);
    const email = ref("");
    const password = ref("");
    const remember = ref(false);
    const loginMessage = ref("");
    const loginMessageClass = ref("");
    computed(() => {
      const meta = document.querySelector('meta[name="csrf-token"]');
      if (meta) return meta.content;
      if (page.props.csrf_token) return page.props.csrf_token;
      return "";
    });
    const isLoggedIn = computed(() => !!props.user);
    onMounted(() => {
      document.addEventListener("click", (e) => {
        if (!e.target.closest(".relative")) {
          showUserInfo.value = false;
        }
      });
    });
    return (_ctx, _push, _parent, _attrs) => {
      var _a;
      _push(`<div${ssrRenderAttrs(mergeProps({ class: "relative" }, _attrs))} data-v-a30ec9b4><button id="loginbtn" class="pt-2 px-2"${ssrRenderAttr("title", ((_a = __props.user) == null ? void 0 : _a.name) || "")} data-v-a30ec9b4><svg class="w-8 h-8 sm:w-10 sm:h-10 min-w-[2rem] min-h-[1rem] text-gray-400" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="User" width="100%" height="100%" data-v-a30ec9b4><title data-v-a30ec9b4>User</title><circle cx="32" cy="20" r="12" fill="none" stroke="currentColor" stroke-width="1.8" data-v-a30ec9b4></circle><path d="M12 54c0-8 6.5-14.5 14.5-14.5h11c8 0 14.5 6.5 14.5 14.5" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" data-v-a30ec9b4></path></svg></button>`);
      if (isLoggedIn.value && showUserInfo.value) {
        _push(`<div class="absolute left-8 mt-2 w-48 bg-white border rounded shadow-2xl z-50 p-4" data-v-a30ec9b4><ul class="space-y-2" data-v-a30ec9b4><li data-v-a30ec9b4>`);
        _push(ssrRenderComponent(unref(Link), { href: "/user/dashboard" }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(`حساب کاربری`);
            } else {
              return [
                createTextVNode("حساب کاربری")
              ];
            }
          }),
          _: 1
        }, _parent));
        _push(`</li><li data-v-a30ec9b4>`);
        _push(ssrRenderComponent(unref(Link), { href: "/user/orders" }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(`سفارشات`);
            } else {
              return [
                createTextVNode("سفارشات")
              ];
            }
          }),
          _: 1
        }, _parent));
        _push(`</li><li data-v-a30ec9b4>`);
        _push(ssrRenderComponent(unref(Link), { href: "/user/addresses" }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(`آدرس‌ها`);
            } else {
              return [
                createTextVNode("آدرس‌ها")
              ];
            }
          }),
          _: 1
        }, _parent));
        _push(`</li><li class="cursor-pointer" data-v-a30ec9b4>خروج</li></ul></div>`);
      } else {
        _push(`<!---->`);
      }
      if (!isLoggedIn.value && showLoginModal.value) {
        _push(`<div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm transition-opacity duration-300" data-v-a30ec9b4><div class="bg-white w-full max-w-md mx-4 p-6 rounded-2xl shadow-xl border border-gray-200 animate-fadeIn" data-v-a30ec9b4><span class="text-2xl font-bold text-center text-gray-800 mb-6 block" data-v-a30ec9b4> ورود به حساب کاربری </span>`);
        if (loginMessage.value) {
          _push(`<div class="${ssrRenderClass([loginMessageClass.value, "text-center p-3 mb-4 rounded font-medium"])}" data-v-a30ec9b4>${ssrInterpolate(loginMessage.value)}</div>`);
        } else {
          _push(`<!---->`);
        }
        _push(`<form data-v-a30ec9b4><div class="space-y-4" data-v-a30ec9b4><input${ssrRenderAttr("value", email.value)} type="email" placeholder="ایمیل" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition" data-v-a30ec9b4><input${ssrRenderAttr("value", password.value)} type="password" placeholder="رمز عبور" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition" data-v-a30ec9b4></div><div class="flex items-center justify-between mt-4" data-v-a30ec9b4><label class="flex items-center" data-v-a30ec9b4><input${ssrIncludeBooleanAttr(Array.isArray(remember.value) ? ssrLooseContain(remember.value, null) : remember.value) ? " checked" : ""} type="checkbox" class="form-checkbox text-blue-600 rounded mr-2" data-v-a30ec9b4><span class="text-sm text-gray-700" data-v-a30ec9b4>مرا به خاطر بسپار</span>`);
        _push(ssrRenderComponent(unref(Link), {
          href: "/register",
          class: "w-full sm:w-auto text-xs text-blue-600 px-4 py-2 text-center"
        }, {
          default: withCtx((_, _push2, _parent2, _scopeId) => {
            if (_push2) {
              _push2(` ثبت‌نام `);
            } else {
              return [
                createTextVNode(" ثبت‌نام ")
              ];
            }
          }),
          _: 1
        }, _parent));
        _push(`</label><a href="#" class="text-sm text-blue-600 hover:underline" data-v-a30ec9b4>رمز را فراموش کرده‌اید؟</a></div><div class="flex flex-col sm:flex-row justify-between gap-2 mt-6" data-v-a30ec9b4><button type="button" class="w-full sm:w-auto px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-md transition" data-v-a30ec9b4> بستن </button><button type="submit" class="w-full sm:w-auto px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition" data-v-a30ec9b4> ورود </button></div></form></div></div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div>`);
    };
  }
};
const _sfc_setup$3 = _sfc_main$3.setup;
_sfc_main$3.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/header/User.vue");
  return _sfc_setup$3 ? _sfc_setup$3(props, ctx) : void 0;
};
const UserMenu = /* @__PURE__ */ _export_sfc(_sfc_main$3, [["__scopeId", "data-v-a30ec9b4"]]);
const _sfc_main$2 = {
  __name: "Header",
  __ssrInlineRender: true,
  setup(__props) {
    var _a;
    ref(false);
    const showUserInfo = ref(false);
    const showCartDropdown = ref(false);
    const showCartOffcanvas = ref(false);
    const page = usePage();
    const cartCount = ref((_a = page.props.cart) == null ? void 0 : _a.count);
    watch(() => {
      var _a2;
      return (_a2 = page.props.cart) == null ? void 0 : _a2.count;
    }, (newVal) => {
      cartCount.value = newVal;
    });
    onMounted(() => {
      document.addEventListener("click", (e) => {
        if (!e.target.closest("#cart-wrapper")) {
          showCartDropdown.value = false;
          showCartOffcanvas.value = false;
        }
        if (!e.target.closest("#loginbtn")) {
          showUserInfo.value = false;
        }
      });
    });
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<header${ssrRenderAttrs(mergeProps({ class: "w-full bg-white fixed top-0 left-0 z-50 box-border mx-auto px-4 items-center pt-1 pb-1 h-fit shadow-xl" }, _attrs))} data-v-c1d4e957><div class="flex flex-col" data-v-c1d4e957><div class="flex justify-between flex-wrap items-center" data-v-c1d4e957><div class="flex-grow-1 sm:order-1 order-2 w-20 md:justify-self-center" data-v-c1d4e957>`);
      _push(ssrRenderComponent(unref(Link), { href: "/" }, {
        default: withCtx((_, _push2, _parent2, _scopeId) => {
          if (_push2) {
            _push2(`<img${ssrRenderAttr("src", _imports_0)} alt="romano logo" class="h-16" data-v-c1d4e957${_scopeId}>`);
          } else {
            return [
              createVNode("img", {
                src: _imports_0,
                alt: "romano logo",
                class: "h-16"
              })
            ];
          }
        }),
        _: 1
      }, _parent));
      _push(`</div><div class="flex grow sm:order-2 order-4 max-sm:w-full justify-center" data-v-c1d4e957><div class="w-3/4 max-sm:w-full ml-5 mb-2 m-2 flex rounded-lg bg-gray-300" data-v-c1d4e957><img${ssrRenderAttr("src", _imports_1$1)} class="w-6 h-6 m-2" alt="" data-v-c1d4e957>`);
      _push(ssrRenderComponent(_sfc_main$6, null, null, _parent));
      _push(`</div></div><div class="flex w-1/5 pb-2 sm-order-3 order-3 pt-2 px-4 space-x-2 justify-end" data-v-c1d4e957>`);
      _push(ssrRenderComponent(UserMenu, {
        user: unref(page).props.auth.user
      }, null, _parent));
      _push(`<div class="relative" id="cart-wrapper" data-v-c1d4e957><button class="flex items-center" data-v-c1d4e957><div class="relative py-2" data-v-c1d4e957>`);
      if (cartCount.value) {
        _push(`<div class="absolute left-5 top-0 md:left-6" data-v-c1d4e957><p class="flex h-2 w-1 sm:h-2 items-center justify-center rounded-full p-3 bg-red-300 text-white" data-v-c1d4e957>${ssrInterpolate(cartCount.value)}</p></div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`<svg class="w-8 h-8 sm:w-10 sm:h-10 min-w-[2rem] min-h-[1rem] text-gray-400" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" data-v-c1d4e957><path d="M10 10h6l8 30h28l6-16H18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-v-c1d4e957></path><circle cx="22" cy="52" r="3" fill="currentColor" data-v-c1d4e957></circle><circle cx="46" cy="52" r="3" fill="currentColor" data-v-c1d4e957></circle></svg></div></button>`);
      if (showCartDropdown.value) {
        _push(`<div class="absolute -left-2 mt-2 w-96 bg-white border rounded shadow-2xl z-50 p-4 hidden sm:block" data-v-c1d4e957>`);
        _push(ssrRenderComponent(_sfc_main$5, null, null, _parent));
        _push(`</div>`);
      } else {
        _push(`<!---->`);
      }
      if (showCartOffcanvas.value) {
        _push(`<div class="fixed top-0 left-0 w-80 h-full bg-white z-50 shadow-lg overflow-y-auto p-2 block sm:hidden" data-v-c1d4e957><div class="p-4 flex justify-between items-center border-b" data-v-c1d4e957><h2 class="text-xl font-bold" data-v-c1d4e957>سبد خرید</h2><button data-v-c1d4e957>✖️</button></div>`);
        _push(ssrRenderComponent(_sfc_main$5, null, null, _parent));
        _push(`</div>`);
      } else {
        _push(`<!---->`);
      }
      _push(`</div></div><div class="order-1 sm:order-4 w-1/5 sm:w-full" data-v-c1d4e957>`);
      _push(ssrRenderComponent(Navbar, null, null, _parent));
      _push(`</div></div></div></header>`);
    };
  }
};
const _sfc_setup$2 = _sfc_main$2.setup;
_sfc_main$2.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/components/header/Header.vue");
  return _sfc_setup$2 ? _sfc_setup$2(props, ctx) : void 0;
};
const Header = /* @__PURE__ */ _export_sfc(_sfc_main$2, [["__scopeId", "data-v-c1d4e957"]]);
const _imports_1 = "/build/assets/enamad-BWohTG4Y.jpg";
const _sfc_main$1 = {
  __name: "footer",
  __ssrInlineRender: true,
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<footer${ssrRenderAttrs(mergeProps({ class: "pb-2" }, _attrs))}><div class="container mt-5 mx-auto"><div class="flex flex-col"><div class="w-full mb-4"><hr class="mb-6"><div dir="rtl" class="flex flex-wrap items-center md:justify-center px-6 py-4"><div class="flex mb-6 lg:w-[110px] w-full justify-center order-1"><img${ssrRenderAttr("src", _imports_0)} alt="logo" class="h-20 lg:h-auto"></div><div class="flex items-start md:border-r-4 border-green-500 md:px-8 md:mr-6 order-2" style="${ssrRenderStyle({})}"><i class="fa fa-phone text-green-500 ml-3 mt-1"></i><div class="flex flex-col text-xl"><small>تماس با پشتیبانی</small><a href="tel:04533275523" class="block sm:hidden my-1 leading-5"> 045-33275523 </a><small class="hidden sm:block my-1 leading-5"> 045-33275523 </small><a href="tel:09144737632" class="block sm:hidden my-1 leading-5"> 09144737632 </a><small class="hidden sm:block my-1 leading-5"> 09144737632 </small></div></div><hr class="mb-6 text-gray-800"><div class="flex items-start md:border-r-4 border-green-500 md:px-8 md:mr-6 md:order-3 order-4" style="${ssrRenderStyle({})}"><i class="fa fa-map-marker-alt text-green-500 ml-3 mt-1"></i><div class="flex flex-col text-xl"><small>نشانی</small><small class="my-1 leading-5">اردبیل،مجتمع تجاری اطلس مال</small><small class="leading-5">همکلف ساحلی پلاک A32</small></div></div><div class="ms-auto mt-4 md:mt-0 order-3 md:order-4 text-center"><a referrerpolicy="origin" target="_blank" href="https://trustseal.enamad.ir/?id=291780&amp;Code=4b7knUf2ahNtAyQ9wjqB"><img referrerpolicy="origin"${ssrRenderAttr("src", _imports_1)} alt="نماد اعتماد" class="border rounded-xl py-2 mx-auto cursor-pointer w-28"></a></div><hr class="text-green-700"></div><div class="flex flex-wrap justify-between mx-auto my-8"><div class="flex flex-wrap md:w-3/4 mx-auto justify-between"><div class="w-1/2 md:w-fit"><button onclick="toggleAccordion(this)" class="accordion-btn flex justify-between items-center w-full text-right font-semibold text-black"> اطلاعات <svg xmlns="http://www.w3.org/2000/svg" class="icon h-4 w-4 transition-transform duration-300 transform rotate-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button><ul class="accordion-content hidden mt-2 space-y-1 text-sm text-gray-700 pr-2"><li><a href="#" class="block hover:text-green-600">درباره اگزو</a></li><li><a href="#" class="block hover:text-green-600">قوانین اگزو</a></li></ul></div><div class="w-1/2 md:w-fit"><button onclick="toggleAccordion(this)" class="accordion-btn flex w-1/2 justify-between items-center md:w-full text-right font-semibold text-black"> اطلاعات <svg xmlns="http://www.w3.org/2000/svg" class="icon h-4 w-4 transition-transform duration-300 transform rotate-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button><ul class="accordion-content hidden mt-2 space-y-1 text-sm text-gray-700 pr-2"><li><a href="#" class="block hover:text-green-600">درباره اگزو</a></li><li><a href="#" class="block hover:text-green-600">قوانین اگزو</a></li></ul></div><div class="w-1/2 md:w-fit"><button onclick="toggleAccordion(this)" class="accordion-btn flex justify-between w-1/2 items-center md:w-full text-right font-semibold text-black"> اطلاعات <svg xmlns="http://www.w3.org/2000/svg" class="icon h-4 w-4 transition-transform duration-300 transform rotate-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button><ul class="accordion-content hidden mt-2 space-y-1 text-sm text-gray-700 pr-2"><li><a href="#" class="block hover:text-green-600">درباره اگزو</a></li><li><a href="#" class="block hover:text-green-600">قوانین اگزو</a></li></ul></div><div class="w-1/2 md:w-fit"><button onclick="toggleAccordion(this)" class="accordion-btn flex justify-between w-1/2 items-center md:w-full text-right font-semibold text-black"> خدمات <svg xmlns="http://www.w3.org/2000/svg" class="icon h-4 w-4 transition-transform duration-300 transform rotate-60" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button><ul class="accordion-content hidden mt-2 space-y-1 text-sm text-gray-700 pr-2"><li><a href="#" class="block hover:text-green-600">شیوه ثبت سفارش</a></li><li><a href="#" class="block hover:text-green-600">شیوه پرداخت</a></li></ul></div></div><div class="flex flex-wrap mx-auto max-md:w-full mt-10 text-wrap text-lg lg:mt-0"><p class="md:hidden w-full px-4">با ما در ارتباط باشید</p><div class="flex items-center md:w-full text-center justify-between max-md:mx-auto flex-wrap text-wrap text-lg mt-4 md:mt-0"><a href="https://www.instagram.com/romanoscarf.ard/" title="instagram"><i class="fab fa-instagram text-3xl px-2 text-red-400"></i></a><a href="https://t.me/romanoscarfard?fbclid=PAZXh0bgNhZW0CMTEAAadPqQ3UKwnnuq-HQdyYc_irEYGBuzN5vTzP7XakBfW-r7foYeIAvNTr4SBwYA_aem_G3M9xHnAXQuSCnK2afAcSw" title="تلگرام"><i class="fab fa-telegram text-3xl px-2 text-blue-400"></i></a></div></div></div><div class="mx-auto text-center text-sm mt-8 text-gray-500">تمامی حقوق این سایت متعلق به رومانو اردبیل میباشد </div><div class="mx-auto text-center text-xs text-gray-500">طراحی و توسعه :محسن علی محمدی </div></div></div></div></footer>`);
    };
  }
};
const _sfc_setup$1 = _sfc_main$1.setup;
_sfc_main$1.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/footer.vue");
  return _sfc_setup$1 ? _sfc_setup$1(props, ctx) : void 0;
};
const _sfc_main = {
  __name: "MainLayout",
  __ssrInlineRender: true,
  setup(__props) {
    return (_ctx, _push, _parent, _attrs) => {
      _push(`<div${ssrRenderAttrs(_attrs)}>`);
      _push(ssrRenderComponent(Header, null, null, _parent));
      _push(`<main class="mt-44 container max-w-screen-lg px-6 sm:px-0 mx-auto">`);
      ssrRenderSlot(_ctx.$slots, "default", {}, null, _push, _parent);
      _push(`</main>`);
      _push(ssrRenderComponent(_sfc_main$1, null, null, _parent));
      _push(`</div>`);
    };
  }
};
const _sfc_setup = _sfc_main.setup;
_sfc_main.setup = (props, ctx) => {
  const ssrContext = useSSRContext();
  (ssrContext.modules || (ssrContext.modules = /* @__PURE__ */ new Set())).add("resources/js/Layouts/MainLayout.vue");
  return _sfc_setup ? _sfc_setup(props, ctx) : void 0;
};
const __vite_glob_1_0 = /* @__PURE__ */ Object.freeze(/* @__PURE__ */ Object.defineProperty({
  __proto__: null,
  default: _sfc_main
}, Symbol.toStringTag, { value: "Module" }));
createServer(
  (page) => createInertiaApp({
    page,
    render: renderToString,
    resolve: (name) => {
      const pages = /* @__PURE__ */ Object.assign({ "./Pages/category.vue": __vite_glob_0_0, "./Pages/category/CategoryProducts.vue": __vite_glob_0_1, "./Pages/category/MobileFilterDrawer.vue": __vite_glob_0_2, "./Pages/category/ProductCard.vue": __vite_glob_0_3, "./Pages/category/filterSidebar.vue": __vite_glob_0_4, "./Pages/home.vue": __vite_glob_0_5, "./Pages/product.vue": __vite_glob_0_6 });
      const layouts = /* @__PURE__ */ Object.assign({ "./Layouts/MainLayout.vue": __vite_glob_1_0 });
      const page2 = pages[`./Pages/${name}.vue`];
      page2.default.layout = layouts["./Layouts/MainLayout.vue"].default;
      return page2;
    },
    setup({ App, props, plugin }) {
      const head = createHead();
      const pinia = createPinia();
      return createSSRApp({
        render: () => h(App, props)
      }).use(plugin).use(head).use(pinia);
    }
  })
);
