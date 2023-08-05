import { onMounted, onUnmounted, ref, computed } from "vue";

export const useBreakPoints = () => {
    let windowWidth = ref(window.innerWidth);

    const onWidthChange = () => {
        windowWidth.value = window.innerWidth;
    }

    onMounted(() => {
        window.addEventListener('resize', onWidthChange);
    })
    onUnmounted(() => {
        window.removeEventListener('resize', onWidthChange);
    })

    const type = computed(() => {
        if(windowWidth.value < 600) {
            return 'phone';
        }

        if(windowWidth.value < 905) {
            return 'tablet'
        }

        if(windowWidth.value < 1000) {
            return 'lg-tablet'
        }

        if(windowWidth.value > 1000) {
            return 'desktop'
        }

        return 'lg';
    });

    const width = computed(() => {
        return windowWidth.value;
    })

    return {type, width};
}