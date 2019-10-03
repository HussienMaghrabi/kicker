<template>
<div>
  <div class="pipline">
   <img style="width: 50%;"  src="/images/Funnel-charts.png" />
          <i class="fas fa-long-arrow-alt-right data1"></i> 
          <i class="fas fa-long-arrow-alt-right data2"></i> 
          <i class="fas fa-long-arrow-alt-right data3"></i> 
          <i class="fas fa-long-arrow-alt-right data4"></i> 
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
 .data1
{
  font-size: 70px;
  height: 2px;
  margin: 10px;
  position: absolute;
  top: 18%;
    left: 34.8%;
  color: #4d5596;
}
.data2
{
  font-size: 50px;
  height: 2px;
  margin: 10px;
  margin-left: 0px;
  top: 53%;
    left: 31%;
  position: absolute;
  color: #019b83

}
.data3
{
  font-size: 50px;
  height: 2px;
  margin: 10px;
  margin-left: 0px;
  top: 63%;
    left: 31%;
  position: absolute;
  color: #e9624f;

}
.data4
{
  font-size: 50px;
  height: 2px;
  margin: 10px;
  margin-left: 0px;
  top: 70.6%;
    left: 31%;
  position: absolute;
  color: #e7cb50;

}
</style>