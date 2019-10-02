<template>
<div>
  <div class="row">
    <div class="sections ">
      <label style="display: inline-block; max-width: 100%; margin-bottom: 25px; font-weight: 700;">
        <div>
          <img
            src="/icon/Image21.png"
            style="width: 30px; margin-right: 15px; margin-left: 15px; margin-top: 15px;"
          >
          <h2
            style="float: right; margin-top: 8%; font-size: 25px; font-weight: bold;"
          >Food Ordering</h2>
        </div>
      </label>
     <div class="columns is-12">
       <div  class="column is-1 imges">
           <img class="img1" src="/images/Image22.png" />
            <img class="img2" src="/images/Image24.png" />
           <img class="img3" src="/images/Image26.png" />
          <img class="img4" src="/images/EBzoEDVX4AAbUS7.0.png" />
       </div>
       <div class="column is-4 cptions">
         <div class="cp">
         <h3 style="font-weight:bold">{{title1}}</h3>
         <p>Super CrunchySuper CrunchySuper CrunchySuper CrunchySuper CrunchySuper Crunchy</p>
         </div>
          <div class="cp2">
         <h3 style="font-weight:bold">{{title2}}</h3>
         <p>Super CrunchySuper CrunchySuper CrunchySuper CrunchySuper CrunchySuper Crunchy</p>
         </div>
          <div class="cp3">
         <h3 style="font-weight:bold">{{title3}}</h3>
         <p>Super CrunchySuper CrunchySuper CrunchySuper CrunchySuper CrunchySuper Crunchy</p>
         </div>
       </div>
       <div class="column is-1 icons1">
         <i v-on:click="decrement1" style="display:block;color:red" class="fas fa-minus-circle icon1"></i>
         <i v-on:click="decrement2" style="display:block;color:red" class="fas fa-minus-circle icon2"></i>
         <i v-on:click="decrement3" style="display:block;color:red" class="fas fa-minus-circle icon3"></i>
       </div>
       <div class="column is-1 quantity">
         <p class="q1">{{counter1}}</p>
         <p class="q2">{{counter2}}</p>
         <p class="q3">{{counter3}}</p>
       </div>
        <div class="column is-1 icons2">
         <i v-on:click="increment1" style="display:block;color:green" class="fas fa-plus-circle icon1"></i> 
         <i v-on:click="increment2" style="display:block;color:green" class="fas fa-plus-circle icon2"></i>
         <i v-on:click="increment3" style="display:block;color:green" class="fas fa-plus-circle icon3"></i>
       </div>
        <div class="column is-1 icons">
         <p style="font-size:12px;font-weight:bold;margin-top:34px">EGP {{price1}}</p>
         <p style="font-size:12px;font-weight:bold;margin-top:80px" >EGP {{price2}}</p>
         <p style="font-size:12px;font-weight:bold;margin-top:95px" >EGP {{price3}}</p>
       </div>
       <div class="column is-4">
         <div class="join">
          <h3>Mostafa</h3>
          <i class="fas fa-user-plus"></i>
          <button>Join</button>
         </div>
         <div class="add_item">
           <h4 style="font-weight:bold">Add Item Choices</h4>
          
           <p v-if="counter1>0" style="font-size:14px;">{{counter1}} {{title1}}</p>
           <p v-if="counter2>0" style="font-size:14px;">{{counter2}} {{title2}}</p>

           <p v-if="counter3>0" style="font-size:14px;">{{counter3}} {{title3}}</p>

         </div>
         <div class="columns is-12 total">
         <div class="column is-6" style="display:inline-block">
           <h3 style="font-size:14px">Subtotal</h3>
           <h3 style="font-size:14px">Service Charge</h3>
           <h3 style="font-size:14px">Vat</h3>
           <h3 style="font-size:14px">Total Amount</h3>

         </div>
         <div class="column is-6" style="display:inline-block">
           <h3>EGP {{total}}</h3>
           <h3> EGP 144.74</h3>
           <h3>EGP 144.74</h3>
           <h3>EGP 144.74 </h3>
         </div>
         </div>
         <div class="notes">
           
           <h2>Notes</h2>
           <textarea></textarea>
           <button>Submit</button>
         </div>
       </div>
    </div>
    </div>
  </div>
  
</div>
</template>

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
             total:0,
             title1:" Super Crunchy",
             title2:"Friskes Fries",
             title3:"Chicken N Cheese Titan"

      };
  },
  methods: {
     increment1() { 
       this.counter1++
       this.total=this.total+this.price1
      },
      increment2() { 
        this.counter2++
         this.total=this.total+this.price2
      },
      increment3() { 
        this.counter3++
         this.total=this.total+this.price3
      },
      decrement1() { 
        if(this.counter1>0)
        {
        this.counter1--
        this.total=this.total-this.price1
        }
        
      },
       decrement2() { 
         if(this.counter2>0)
         {
            this.counter2--
            this.total=this.total-this.price2
         }
       

      },
       decrement3() { 
         if(this.counter3>0)
         {
           this.counter3--
           this.total=this.total-this.price3
         }
     

      },
      
  },
  
};
</script>

<style>
@media screen and (min-width:414px)
{
.cp {
    bottom: 71.2% !important;
}
.cp2 {
    bottom: 69.8% ;
}

.cp3
{
  bottom: 68% 
}
}
@media screen and (max-width: 768px)
{
  
    .imges .img2
    {
      width: 15%;
      display: block;
      margin-top: 0px !important;
    }
    .imges .img3
    {
      width: 15%;
      display: block;
      margin-top: 20px !important;
    
    }
    .imges .img4
    {
      width: 15%;
      display: block;
      margin-top: 48px !important;
    }
    .cp
    {
      position: absolute;

        bottom: 71% !important;
        left: 48px !important;
        width: 52%;
    }
    .cp2
    {
      position: absolute;
      bottom :70% !important;    
     left: 48px;
      width: 52%;
    }
    .cp3
    {
      position: absolute;

       bottom: 68.5% !important;
        left: 48px !important;
        width: 52%;
    }
    .icons1
    { 
      position: absolute;
      right: 19%;
      top: 25.6%;

    }
    .icons2
    { 
      position: absolute;
      right: 2%;
      top: 25.6%;

    }
    .q1
    {
      width: 14%;
    position: absolute;
    top: 26.7%;
    right: 8%;
   }
   .q2
   {
     width: 14%;
    position: absolute;
    top: 27.5%;
    right: 8%;
   }
   .q3
   {
     width: 14%;
    position: absolute;
    top: 29.1%;
    right: 8%;
   }
   .icons
   {
     position: absolute;
    top: 26%;
    right: 7%;
   }
  .join h3 
  {
    margin-left: 9px;
  }
   
}

@media screen and (max-width: 375px)
 {
   .cp
{
     bottom: 71% !important;


}
.cp2
{
      bottom: 69.7% !important;

}
.cp3
{
  bottom: 68% !important;
}
.icons1 , .icons2
{
  top: 26% !important;
}
.icons 
{
  top:26.5% !important;
}
.q1
{
    width: 9% !important;
    position: absolute !important;
    top:27.5%  !important;
    right: 10.4% !important;
}
.q2
{
    width: 9% !important;
    position: absolute !important;
    top: 28.2% !important;
    right: 10.4% !important;
}
.q3
{
    width: 9% !important;
    position: absolute !important;
    top: 30% !important;
    right: 10.4% !important;
}

 }
@media screen and (max-width: 1024px)
{
    .notes textarea
    {
          width:100%;
    }
    .imges .img2
    {
          margin-top: 38px ;
    }
    .imges .img3
    {
         margin-top: 88px ;
    }
    .imges .img4
    {
         margin-top: 70px ;
    }
}
@media screen and (max-width: 414px)
 {
   .cp
{
    bottom: 71.6% ;
    margin-left: 24px;
}
.cp2
{
      bottom: 70.3% ;
}
.cp3
{
  bottom: 68.4% ;
}
.icons1 , .icons2
{
  top: 25.5% ;
}
.icons 
{ 
  top:25.9% ;
}
.q1
{
   width: 9%;
   position: absolute;
   top: 26.9%;
   right: 10.4%;
}
.q2
{
    width: 9%;
    position: absolute;
    top: 27.7%;
    right: 10.4%;
}
.q3
{
    width: 9%;
    position: absolute;
    top: 29.4%;
    right: 10.4%;
}

 }
@media screen and (max-width: 1024px)
{
    .notes textarea
    {
          width:100%;
    }
    .imges .img2
    {
          margin-top: 38px ;
    }
    .imges .img3
    {
         margin-top: 88px ;
    }
    .imges .img4
    {
         margin-top: 70px ;
    }
}
@media screen and (min-width: 769px)
{
   .column .is-4
{
  width: 30% ;
}
}
.notes
{
   background-color: #eadbc2;
   padding: 15px;
    margin-top: 10px;
    padding-right: 0px;
    width: 92%
}
.notes button
{
  width: 60px;
  height: 30px;
}
.total
{
  background-color: #eadbc2;
  margin-left: 1px;
  padding: 15px;
  padding-right:0px;
  width: 92%;
}
.add_item
{
  background-color: #eadbc2;
  padding: 15px;
  margin-top: 3px;
 padding-right: 0px;
 width: 92%;
}
.brdr
{
  /* display: inline; */

  border: solid 1px black;
  width: 30%;
  text-align: center;
  margin-top: 15px;
}
.brdr p 
{
  display: inline;
  border-right: solid 1px black;
  border-left: solid 1px black;
  padding: 4px;
}
.brdr i
{
  color: green
}
.join h3 
{
  display: inline;
  font-weight: bold;
  font-size: 20px;
  margin-right: 50PX;
}
.join button
{
  width: 60px;
  height: 30px;
}
.q1
{
  margin-top: 25px;
}
.q2
{
  margin-top: 78px;
}
.q3
{
  margin-top: 84px;
}
.imges img
{
  margin-top: 20px;
  margin-left: 10px;
}
.cp
{
  margin: 15px;

}
.cp2
{
  margin-top: 40px;
  margin-left: 15px;
}
.cp3
{
  margin-top: 45px;
  margin-left: 20px
}
.icon1
{
  margin-top: 30px;
}
.icon2
{
  margin-top: 70px
}
.icon3
{
  margin-top: 83px;
}
.quantity
{
  margin-top: 90px;
  margin-right: 15px;
 text-align: center;
 position: unset !important;
}
.quantity p
{
  font-size: 14px;
  border-radius: 60%;
  border: 1px green solid;
}
.cptions
{
  margin-top: 80px;
  font-size: 12px
}
.icons
{
  margin-top: 80px;
  font-size: 30px;
}
.icons1
{
  margin-top: 80px;
  font-size: 30px;
}
.icons2
{
  margin-top: 80px;
  font-size: 30px;
}
.sections,
.right-side {
  background: #f2e8da;
  margin-bottom: 5%;
  padding-bottom: 3%;
  height: fit-content;
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
@media screen and (max-width: 767px)
{
.followUpDivs[data-v-6333ff8b] {
    display: none !important;
}
}
</style>