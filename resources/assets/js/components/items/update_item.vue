<template>
    <div class="container" style="background-color:#fff;padding:3%">
       <div class="columns is-12 is-mobile updateitem_container" style="margin-bottom:3%">
           <div class="column is-10 filter_label">
               <b style="font-size:18px ;">Update Item</b>
           </div>
           
           <div class="column is-1 top_btns">
               <b-button type="is-info marg_btn"><i class="fas fa-pen-nib"></i> &nbsp;Update</b-button>
           </div>
           <div  class="column is-1">
               <b-button type="is-danger"><i class="fas fa-window-close"></i> &nbsp;Cancel</b-button>
           </div>
       </div>

       <div class="columns is-12 " style="margin-top: -5%;">
          
           <hr>
       </div>

        <div class="columns is-12 is-mobile" style="border-bottom: solid 1px lightgray;padding-bottom: 5px;">
               <h4 style="color:#9A9A9A;border-bottom:#solid 3px #000 ;margin-left: 2%;">Update Item Data</h4>
        </div>

        <div class="columns is-12 " style="margin-top:10px;padding-bottom:15px ">
            <div class="column is-2 ">
                <b-field style="padding-right: 6px;" class="filter_pic">
                    <b-upload v-model="dropFiles"
                        multiple
                        drag-drop>
                        <section class="section">
                            <div class="content has-text-centered">
                                <p>
                                    <b-icon
                                        icon="upload"
                                        size="is-large">
                                    </b-icon>
                                </p>
                                <p>Drop your files here or click to upload</p>
                            </div>
                        </section>
                    </b-upload>
                </b-field>
            </div>

            
           

            <div class="column is-12">
                <b-field >  
                    <label class="column is-2 filter_label">Item name</label>
                    <b-input  class="column is-4" type="text" style="margin-left: -9%;"  placeholder="item name"
                    
                    v-for="item in items" :key="item.id" v-model="item.name" 
                    ></b-input>
                </b-field>       

                <b-field>
                    <label class="column is-2 filter_label">Description</label>
                    <b-input class="column is-4"  type="textarea" style="margin-left:-9%;" 
                     v-for="desc in description" :key="desc.id" v-model="desc.description" 
                    ></b-input>
                </b-field>
            </div>

        </div>

        <p style="margin-bottom: 2%; margin-left: 10%;" class="filter_item" >Item Specifications</p>
        <div class="columns is-12 is-mobile addspecification_filter">
           <div class="column is-1 add_btn  filter_add  " >
                <span><img src="/images/add.png" style="cursor:pointer" @click="addspecification"></span> 
            </div>
            <h4 style="color:#9A9A9A ;margin-left: -6%;">Add Specification</h4>
        </div>

        <div style="margin-top:10px;padding-bottom:15px ;" v-if="indexAddress > 0"
         v-for="(address, indexAddress) in addresses" :key="indexAddress">

         <div class="columns is-12"  v-if="seen" style="margin-left:26%;">
             
                <b-field class="column is-1 is-mobile filter_field1">
                    <b-input type="text" style="margin-left:5%; "   v-model="street" placeholder="new item" class="newitem_field"></b-input>
                </b-field> 

                <b-field class="column is-3 is-mobile filter_field2">
                    <b-input type="text" style="margin-left:5%; " v-model="state" placeholder="new item" class="newitem_field"></b-input>
                </b-field>
                   <span style="margin-top:0.8%"><img src="/images/remove.png" style="cursor:pointer" @click="removeAddressfield(indexAddress,address)"></span> 
            
          </div>
        </div>


         <div class="columns is-12 is-mobile  bottom_btns" style="margin-bottom:3%">
           
           
           <div class="column is-11 ">
               <b-button type="is-info marg_btn"> <i class="fas fa-pen-nib"></i> &nbsp;Update</b-button>
           </div>
           <div  class="column is-1">
               <b-button type="is-danger"><i class="fas fa-window-close"></i> &nbsp; Cancel</b-button>
           </div>
       </div>
    </div>
</template>

<script>
import {getItemName ,getDescription } from './../../calls'
export default {
     data() {
        return {
            items:[],
            description:[],
            dropFiles: [],
            phones:[{
                newPhone:''
                }],
            mobiles:[{
                newMobile:''
            }],
            emails:[{
                newMail:''
            }],
            faxes:[{
                newFax:''
            }],
            addresses:[{
                street:'',
                state:'',
                country:'',
                city:'',
                zipCode:''
            }],
            contacts:[{
                removebtn:'',
                title:'',
                firtsName:'',
                lastName:'',
                email:'',
                nationality:'',
                phone:'',
                mobile:'',
                leadStatus:'',
                position:''
            }],
            seen:false,
        }
     },
    mounted() {
            this.getItemName()
            this.getDescription()
        },
        
    created() {
            this.id = this.$route.params.id
        },

      methods: {
        
        //   getItemName(){
        //     getItemName(this.id)-then(Response=>{ 
        //           this.items=Response.data.data
        //           console.log("items---------------------------------",Response)
        //           console.log("items---------------------------------")

        //       }).catch(error=>{
        //           console.log(error);
        //       })

        // },

        getItemName(id){
              getItemName(this.id).then(Response=>{
                  console.log(Response)
                  this.items=Response.data.data
                  console.log("--------------------",this.items)

              }).catch(error=>{
                  console.log(error);
              })
          },

          getDescription(id){
              getDescription(this.id).then(Response=>{
                  console.log(Response)
                  this.description=Response.data.data
                  console.log("--------------------",this.items)

              }).catch(error=>{
                  console.log(error);
              })
          },
          
        removeAddressfield(indexAddress,address){
           var idx = this.addresses.indexOf(address);
            console.log(idx, indexAddress);
            if (idx > -1) {
                this.addresses.splice(idx, 1);
            }
        },
        addspecification(){
            this.seen=true;
            this.addresses.push({
                street:'',
                state:'',
                country:'',
                city:'',
                zipCode:''  
            });
            
        },

        
        
      },
    
    
}
</script>

<style>
.marg_btn{
float: right;
position:relative;
}

.add_btn{

    margin-left :17%;
}
@media screen and (max-width: 767px) {

.bottom_btns{

    margin-left: -23%;
}

.top_btns{

    margin-left: -18%;
   
    
}
.filter_item{

    margin-left: 1% !important;
    margin-bottom: 1% !important;

}
.filter_add{

        margin-right: 6%;
}
.filter_pic{
    margin-left: 10%;
    margin-bottom: 1%;
}
.filter{

    margin-top: 3%;
}
.updateitem_container{

        margin-top: -2%;
}
.filter_label
{
   
    margin-left: 2%;

}
.filter_field1{

    margin-right: 63%;
}
.filter_field2{

    margin-right: 40%;
}
.addspecification_filter
{
    margin-top: 2%;
}
}


</style>