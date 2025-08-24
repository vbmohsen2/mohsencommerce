# Laravel + Vue + Inertia Project

این پروژه یک وب‌اپلیکیشن شخصی است که بیشتر برای نمونه‌کار و علاقه شخصی توسعه داده شده است.  
ساختار پروژه بر پایه **Laravel**، **Vue 3** و **Inertia.js** پیاده‌سازی شده و در شاخه‌های مختلف نسخه‌های متفاوت آن وجود دارد.

---

## 📌 Branches

- **main**  
  نسخه اولیه پروژه که ساختار اصلی و پایه پیاده‌سازی شده و کاملاً قابل اجراست.

- **romanoscarf**  
  نسخه شخصی‌سازی‌شده برای یک فروشگاه شال و روسری.
    - رفع برخی باگ‌های اولیه
    - استفاده کامل از Vue برای همه صفحات

- **inertia-refactor**  
  نسخه بازنویسی‌شده و بهینه‌تر پروژه.
    - رفع باگ‌های بیشتر
    - اضافه شدن قابلیت SSR (Server-Side Rendering)
    - بهبود ساختار کد و رندرینگ سمت سرور

---

## 🛠️ تکنولوژی‌های استفاده‌شده

- [Laravel](https://laravel.com/) – فریم‌ورک بک‌اند PHP
- [Vue 3](https://vuejs.org/) – فریم‌ورک فرانت‌اند جاوااسکریپت
- [Inertia.js](https://inertiajs.com/) – پل ارتباطی بین Vue و لاراول
- [Tailwind CSS](https://tailwindcss.com/) – فریم‌ورک طراحی رابط کاربری
- SSR (Server-Side Rendering) – برای بهبود سئو و سرعت بارگذاری

---

## ⚙️ راه‌اندازی پروژه

1. مخزن را کلون کنید:
   ```bash
   git clone https://github.com/your-username/your-repo.git
   cd your-repo


2. نصب وابستگی‌های PHP:
   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   
3. تنظیم دیتابیس در فایل .env و سپس اجرای migration:
    ```bash
    php artisan migrate --seed

4. نصب وابستگی‌های جاوااسکریپت:

    ```bash
    npm install
   npm run dev

5. اجرای پروژه:
     ```bash
   php artisan serve

✨ ویژگی‌ها

ساختار ماژولار و مقیاس‌پذیر

استفاده کامل از Vue برای تمام صفحات

طراحی مدرن و واکنش‌گرا با Tailwind

بهینه‌سازی با SSR برای سرعت بیشتر و سئوی بهتر

چند نسخه با شاخه‌های مختلف برای اهداف متفاوت


