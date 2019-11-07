<template>
 <div>

     <input v-modal="filtertext">
     <ul>
         <li v-for="fruit in filterfriuts" :key="fruit">{{fruit}}</li>
     </ul>


 </div>

</template>
<style>


</style>


<script>
export default {
  data () {
    return {
        fruits:['banana','kewy' ,'apple' ,'mango'],
        filtertext:''
      
  }
} ,
computed:{

    filterfriuts(){

        return this.fruits.filter((element) => {

            return element.match(this.filtertext);
        });
    }

}
}
</script>