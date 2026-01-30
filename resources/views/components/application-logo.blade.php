<svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
    <!-- Background -->
    <defs>
        <linearGradient id="bg" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0%" stop-color="#c4b5fd"/> <!-- lavender -->
            <stop offset="100%" stop-color="#4f46e5"/> <!-- indigo -->
        </linearGradient>
    </defs>

    <rect x="20" y="20" width="160" height="160" rx="28" fill="url(#bg)"/>

    <!-- Task cards -->
    <rect x="55" y="58" width="90" height="18" rx="6" fill="white" opacity="0.9"/>
    <rect x="55" y="86" width="90" height="18" rx="6" fill="white" opacity="0.85"/>
    <rect x="55" y="114" width="90" height="18" rx="6" fill="white"/>

    <!-- Progress dot (teal accent) -->
    <circle cx="145" cy="123" r="6" fill="#14b8a6"/>
</svg>
