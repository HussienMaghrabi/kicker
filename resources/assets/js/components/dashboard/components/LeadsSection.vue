<template>
<div>
  <div class="food_order">
      
    <table id="scroll" style="width:100%;height:100%;border:none" class="table  table-borderless table-hover">
  <thead>
    <tr>
      <td scope="col"> Items</td>
      <td scope="col"> Description</td>
      <td scope="col">Dec</td>
      <td scope="col">Counter</td>
      <td scope="col">Inc</td>
      <td scope="col"> Price</td>

    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="width:12%"> <img style="height:60%;"  src="/images/Image24.png" /></td>
      <td style="width:23%">  <span style="font-weight:bold">{{title1}}</span> <br> Super CrunchySuper CrunchySuper CrunchySuper CrunchySuper CrunchySuper Crunchy  </td>
      <td  style="width:12%"><i v-on:click="decrement1" style="color:red;font-size: 27px;margin-top: 18px;" class="fas fa-minus-circle icon1"></i></td>
      <td  style="width:12%"><p class="q1">{{counter1}}</p></td>
      <td  style="width:12%"><i v-on:click="increment1" style="color:green;font-size: 27px;margin-top: 18px;" class="fas fa-plus-circle icon1"></i></td>
      <td  style="width:12%"><p style="margin-top:18px" >{{price1}} EGP</p></td>
    </tr>
    <tr>
      <td  style="width:12%"><img style="height:60%" src="/images/Image24.png" /></td>
      <td style="width:23%">  <span style="font-weight:bold">{{title2}}</span> <br> Super CrunchySuper CrunchySuper CrunchySuper CrunchySuper CrunchySuper Crunchy  </td>
      <td  style="width:12%"><i v-on:click="decrement2" style="color:red;font-size: 27px;margin-top: 18px;" class="fas fa-minus-circle icon1"></i></td>
      <td  style="width:12%"><p class="q1">{{counter2}}</p></td>
      <td  style="width:12%"><i v-on:click="increment2" style="color:green;font-size: 27px;margin-top: 18px;" class="fas fa-plus-circle icon1"></i></td>
      <td  style="width:12%"><p style="margin-top:18px" >{{price2}} EGP</p></td>

    </tr>
    <tr>
      <td  style="width:12%"><img style="height:60%" src="/images/Image24.png" /></td>
      <td style="width:23%">  <span style="font-weight:bold">{{title3}}</span> <br> Super CrunchySuper CrunchySuper CrunchySuper CrunchySuper CrunchySuper Crunchy  </td>
      <td  style="width:12%"><i v-on:click="decrement3" style="color:red;font-size: 27px;margin-top: 18px;" class="fas fa-minus-circle icon1"></i></td>
      <td  style="width:12%"><p class="q1">{{counter3}}</p></td>
      <td  style="width:12%"><i v-on:click="increment3" style="color:green;font-size: 27px;margin-top: 18px;" class="fas fa-plus-circle icon1"></i> </td> 
      <td  style="width:12%"><p style="margin-top:18px" >{{price3}} EGP</p></td>

    </tr>
  </tbody>
</table>
</div>
<div class="selected_items">
    <div class="hdr">
       <p style="padding:3%">Selected Items</p>
  </div>
  <div>
    <p v-if="counter1>0" style="font-size:14px;margin:5px;"><span style="color:red">{{counter1}}</span> {{title1}}</p>
    <p v-if="counter2>0" style="font-size:14px;margin:5px;"><span style="color:red">{{counter2}} </span> {{title2}}</p>
    <p v-if="counter3>0" style="font-size:14px;margin:5px;"><span style="color:red">{{counter3}} </span> {{title3}}</p>
    <p style="margin-top:8px"><span style="margin-left:4px">SubTotal</span><span style="color:red;float:right;margin-right:4px">{{sub_total }} EGP</span></p>
    <p style="margin-top:4px"><span style="margin-left:4px">Service Charge</span><span style="color:red;float:right;margin-right:4px">{{Service }} EGP</span></p>
    <p style="margin-top:4px"><span style="margin-left:4px">Vat</span><span style="color:red;float:right;margin-right:4px">{{Vat }} EGP</span></p>
    <p style="margin-top:4px"><span style="margin-left:4px">Total Amount</span><span style="color:red;float:right;margin-right:4px">{{total_amount }} EGP</span></p>
  </div>
</div>
<div class="total_price">
  <p style="display:inline;margin-left:21%" ><i class="far fa-user"></i> <span>Mostafa</span></p>
  <b-button style="margin-top: 3%;margin-left: 31%;" type="is-primary" outlined>Join</b-button>
  
</div>
</div>
</template>
<style scoped>
.food_order
{
    width: 69%;
    border: 1px solid #ccc;
    margin-left: 2%;
    margin-top: 1%;
    display: inline-block;
}
.selected_items
{
    width: 13%;
    border: 1px solid #ccc;
    margin-left: 0.5%;
    margin-top: 1%;
    display: inline-block;
    height: 294px;
    position: absolute;
    background-color: white;
}
.total_price
{
    
    border: 1px solid #ccc;
    margin-left: 0.5%;
    display: inline-block; 
    height: 294px;
    background-color: white;
    width: 14%;
    position: absolute;
    right: 2%;
    margin-top: 1%;
}
.hdr 
{
  background-color: #ECECEC;
    height: 32px;
    font-size: 16;
    width: 100%;
}
.table td
{
  border: none;
  /* text-align: center */
}
table td:not([align]), table th:not([align]) {
    text-align: left;
    font-size: 12px
}
.table th
{
  border: none;

}
.table th:not([align]) {
    text-align: center;
}
.table thead {
    background-color: #ececec;
}
.q1
{
  font-size: 14px;
    border-radius: 48%;
    border: 1px green solid;
    width: 30%;
    margin-top: 18px;
    text-align: center;
}
</style>
<script>

export default {
  
  data() {
    
      return {
             counter1: 0,
             newcounter1:0,
             newcounter:0,
             oldcounter1:0,
             counter2: 0,
             counter3: 0,
             price1:100,
             price2:200,
             price3:300,
             sub_total:0,
             total_amount:0,
             Service:0,
             Vat:0,
             title1:" Super Crunchy",
             title2:"Friskes Fries",
             title3:"Chicken N Cheese Titan"

      };
  },
  methods: {
     increment1() { 
       this.counter1++
       this.sub_total=this.sub_total+this.price1
      },
      increment2() { 
        this.counter2++
         this.sub_total=this.sub_total+this.price2
      },
      increment3() { 
        this.counter3++
         this.sub_total=this.sub_total+this.price3
      },
      decrement1() { 
        if(this.counter1>0)
        {
        this.counter1--
        this.sub_total=this.sub_total-this.price1
        }
        
      },
       decrement2() { 
         if(this.counter2>0)
         {
            this.counter2--
            this.sub_total=this.sub_total-this.price2
         }
       

      },
       decrement3() { 
         if(this.counter3>0)
         {
           this.counter3--
           this.sub_total=this.sub_total-this.price3
         }
     

      },
      
  },
  
};
</script>
