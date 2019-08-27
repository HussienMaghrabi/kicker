<script>

import { Sortable } from '@shopify/draggable'


export default {
    props: [],
    render() {
        return this.$slots.default[0]
    },
    mounted() {
       let s = new Sortable(this.$el, {
            draggable: '.sections',
            handle: '.sections',
            mirror: {
                constrainDimensions: true,
            },
            disabled: true,
        });
    }
}
</script>
