<template>
<div>
    <div class="a1">    
        <h1>Done <i class="fas fa-ellipsis-h a3"></i> </h1>
        
        <div class="a2">  <p>click me</p></div>
        <div class="a2"> <p> Exam </p></div>
        <p class="a5" v-on:click="seen = !seen"> <i class="fas fa-plus"></i> Add another card </p>
        <div v-if="seen">

            <b-input placeholder="enter ......." class="a6"> </b-input>
            <button class="a4"> ADD Card</button>
            <i class="fas fa-times"></i> 
            <i class="fas fa-ellipsis-h a3" v-on:click ="seen2=!seen2"></i> 
        </div>
        <div v-if="seen2" class="a7">
            <div>
                <h3>option1</h3>
                <i class="fas fa-times , a3"></i> 
            
            </div>
            <div> 
                <p>Members</p> 
                <p>Label</p>
                <p>Position</p>
            
            
            </div>

        </div>

    </div>
    
        </div>
</template>
<style scoped>
.a1{

    width:20%;
    background-color: #ebecf2;
    margin:15px;
    position: relative;

    
    
}
.a2{

    width:80%;
     height: 100px;
    background-color: #ffffff;
    
   margin: auto;
   margin-bottom: 10px;
   padding:4px;
}
.a3{

    float:right;
}
.a4{

    background-color: #55832b;
    padding:4px;
    color:beige;
    height: 35px;
}
.a6{

    margin: 10px;

}

.a7{

  position: absolute;
    background-color: white;
    bottom: -43px;
    right: -71px;
    width: 66%;

}
@media screen and (max-width: 700px)
{
.a2,.a5
{
    font-size: 7px
}
.a1{

    width:35%;
}
}
</style>
<script>
export default {
    data()
    {
        return {
            seen:false,
            seen2:false,
        }
    },
}

</script>
