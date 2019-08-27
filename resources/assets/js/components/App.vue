<template>
    <div>
        <Header />
        <router-view></router-view>
        <Footer />      
    </div>
</template>
<script>
    import Header from './Layout/Header'
    import Footer from './Layout/Footer'
    export default {
        data() {
            return {

            }
        },

        mounted() {

        },
        components: {
            Header: Header,
            Footer: Footer,
        },
        methods:{
            
        }
    }
</script>