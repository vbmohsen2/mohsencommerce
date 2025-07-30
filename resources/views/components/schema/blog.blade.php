<script type="application/ld+json">
    {!! json_encode([
        "@context" => "https://schema.org",
        "@type" => "Blog",
        "name" => config('app.name'),
        "url" => url('/blog'),
        "description" => "مطالب و آموزش‌های مرتبط با شال، روسری، استایل و مد از فروشگاه رومانو",
        "publisher" => [
            "@type" => "Organization",
            "name" => "Romano",
            "logo" => [
                "@type" => "ImageObject",
                "url" => asset('logo.png')
            ]
        ]
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
