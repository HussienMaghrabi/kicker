<template>
<div>
  <div class="pipline">
   <img style="width: 50%;"  src="/images/Funnel-charts.png" />
          <!--  -->
          <div class="pipeline-info">
             <div><i style="color:#4d5596;margin:10px" class="fas fa-square"></i>aaa</div>
             <div><i style="color:#019b83;margin:10px" class="fas fa-square"></i>bbb</div>
             <div><i style="color:#e9624f;margin:10px" class="fas fa-square"></i>ccc</div>
             <div><i style="color:#e7cb50;margin:10px" class="fas fa-square"></i>ddd</div>
          </div>
  </div>
  <div class="birthday"> 
    <div> <img style="width:50%" src="/images/Image28.png" /></div>
    <div>
       <p> Happy Birthday,,10 July</p>
       <p>Wish him a happy birthday <i class="fas fa-birthday-cake"></i></p>
       <b-button style="margin-top: 3%;" type="is-primary" outlined>Submit</b-button>
    </div>

  </div>
</div>
</template>
<style scoped>
.birthday
{
    width: 27.5%;
    border: 1px solid #ccc;
    margin-left: 0.5%;
    margin-top: 0.5%;
    margin-bottom: 0.5;
    display: inline-block;
    background-color: white;
    position: absolute;
    padding-bottom: 0.8%
}
.pipeline-info
{
    float: right;
    margin-right: 2%;
    margin-top: 7%;
}
 .pipline
 {
    width: 69%;
    border: 1px solid #ccc;
    margin-left: 2%;
    margin-top: 0.5%;
    margin-bottom: 0.5;
    display: inline-block;
    background-color: white;
    position: relative;
 }
 
@media (max-width:414px)
{
  .pipline
 {
   width: 97%;
  margin-left: 2%;
    display: block;
    height: 176px;
  
    /* position: relative; */
 }
 .birthday
 {
   width: 94.5%;
    margin-left: 3.5%;
   position: unset
 }

}
</style>