<template>
  <div class="row">
    <div class="sections">
      <label
        style="display: inline-block; max-width: 100%; margin: 25px; font-weight: 700;"
      >
        <div>
          
          <h2
            style="float: right; margin-top: 8%; font-size: 25px; font-weight: bold;"
          ><i class="far fa-chart-bar"> &nbsp;</i> Pipeline</h2>
        </div>
      </label>
      <div class="columns is-12" style="position:relative">
        <div class="column is-6">
            <img src="/images/Funnel-charts.png" />

        </div>
        <div class="column is-6">
           <div class="column is-6"> 
          <i class="fas fa-long-arrow-alt-right data1"></i> 
          <i class="fas fa-long-arrow-alt-right data2"></i> 
          <i class="fas fa-long-arrow-alt-right data3"></i> 
          <i class="fas fa-long-arrow-alt-right data4"></i> 
           </div>
           <div style="float:right" class="column is-3">
             <div><i style="color:#e7cb50;margin:10px" class="fas fa-square"></i>aaa</div>
             <div><i style="color:#e9624f;margin:10px" class="fas fa-square"></i>bbb</div>
             <div><i style="color:#019b83;margin:10px" class="fas fa-square"></i>ccc</div>
             <div><i style="color:#4d5596;margin:10px" class="fas fa-square"></i>ddd</div>
           </div>
        </div>
         
        </div>
        
      </div>
    </div>
</template>
            
<script>

export default {
  
  data() {
    return {};
  }
};
</script>
<style scoped>
.sections,
.right-side {
  background: #f2e8da;
  margin-bottom: 5%;
  padding-bottom: 3%;
  height: fit-content;
}
.data1
{
  font-size: 70px;
  height: 2px;
  margin: 10px;
  position: absolute;
  top: 40px;
  left: 321px;
  color: #4d5596;
}
.data2
{
  font-size: 50px;
  height: 2px;
  margin: 10px;
  margin-left: 0px;
  top: 145px;
  left: 277px;
  position: absolute;
  color: #019b83

}.data3
{
  font-size: 50px;
  height: 2px;
  margin: 10px;
  margin-left: 0px;
  top: 174px;
  left: 266px;
  position: absolute;
  color: #e9624f;

}
.data4
{
  font-size: 50px;
  height: 2px;
  margin: 10px;
  margin-left: 0px;
  top: 195px;
  left: 265px;
  position: absolute;
  color: #e7cb50;

}
.sections h2 {
  font-size: 30px;
  margin-bottom: 3%;
}

.sections h2 img {
  width: 50px !important;
  margin-right: 15px;
  margin-left: 15px;
  margin-top: 15px;
}

.sections .div-title {
  background: #efefef;
  padding: 5px 10px 5px 10px;
  margin: 0;
  text-align: center;
}

.sections .div-value {
  font-size: 46px;
  font-weight: 600;
  margin: 0;
  background-color: white;
  text-align: center;
}

.sections .div-footer {
  background-color: white;
  text-align: center;
}

@media screen and (max-width: 1087px) {
  .table{
    display: none !important;
  }
}
</style>
