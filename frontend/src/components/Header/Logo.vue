<template>
    <div class="header__logo">
        <div class="logo__icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-box-icon lucide-box">
            <path
                d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z" />
            <path d="m3.3 7 8.7 5 8.7-5" />
            <path d="M12 22V12" />
        </svg>
    </div>
        <h1 class="logo__text">ReqBin</h1>
    </div>
</template>

<style>
.header__logo {
    display: flex;
    align-items: center;
    gap: 0.5em;
}

.logo__text {
    font-size: 1.2em;
}

.logo__icon {
    background-color: rgb(5, 5, 5);
    border-radius: 0.8em;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.5em;
    height: 2.5em;
}

.logo__icon svg {
    stroke: white;
    height: 1em;
}

@media (max-width: 768px) {
    .logo__text {
        display: none;
    }
}
</style>