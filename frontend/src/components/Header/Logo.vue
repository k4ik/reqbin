<template>
    <div class="header__logo">
        <div class="logo__icon">
            <svg xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round">
                <path
                    d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z" />
                <path d="m3.3 7 8.7 5 8.7-5" />
                <path d="M12 22V12" />
            </svg>
        </div>

        <h1 class="logo__text">ReqBin</h1>
    </div>
</template>

<style scoped>
.header__logo {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.logo__icon {
    width: 2.3rem;
    height: 2.3rem;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 0.6rem;

    background:
        linear-gradient(
            135deg,
            #7c5cff,
            #5b8cff
        );
}

.logo__icon svg {
    width: 1rem;
    height: 1rem;

    stroke: white;
}

.logo__text {
    font-size: 1rem;
    font-weight: 700;

    letter-spacing: -0.03em;
}

@media (max-width: 768px) {
    .logo__text {
        display: none;
    }
}
</style>