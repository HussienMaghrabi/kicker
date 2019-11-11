<template>
<div> 
  <div class="unfinishedprojects">
    <table id="scroll" style="width:100%;height:100%;border:none " class="table  table-borderless table-hover table-rspnsv">
  <thead>
    <tr>
      <td scope="col">Unfinished projects</td>
      <td scope="col">Employee</td>
      <td scope="col">Component</td>
      <td scope="col">Progress</td>
      <td scope="col">Delivery Date</td>

    </tr>
  </thead>
  <tbody>
    <tr>
      <td><span style="color:#19A2D0">Rofida Real Estate Group</span> -  CRM</td>
      <td>admin</td>
      <td>UI_p1</td>
      <td>50  <b-progress :value="20"></b-progress> 
      </td>

      <td style="color:#D98F6E">2015-04-23</td>

    </tr>
    <tr>
      <td><span style="color:#19A2D0">Rofida Real Estate Group</span> - CRM</td>
      <td>admin</td>
      <td>UI_p1</td>
      <td>50</td>
      <td style="color:#D98F6E">2015-04-23</td>

    </tr>
    <tr>
      <td><span style="color:#19A2D0">Rofida Real Estate Group</span> - CRM</td>
      <td>admin</td>
      <td>UI_p1</td>
      <td>50</td>
      <td style="color:#D98F6E">2015-04-23</td>

    </tr>
     <tr>
      <td><span style="color:#19A2D0">Rofida Real Estate Group</span>- CRM</td>
      <td>admin</td>
      <td>UI_p1</td>
      <td>50</td>
      <td style="color:#D98F6E">2015-04-23</td>

    </tr>
    
  </tbody>
</table>

  </div>
  <div class="pendingprojects">
    <div class="hdr">
       <p style="padding:3%">Pending Projects</p>
  </div>
</div>

<!-- ------------------------------------------------ -->

<div class="proposals ">
   <div  class="icon-show"> 
        <b-input placeholder="search"></b-input>
     
      </div>
   <table id="scroll" style="width:100%;height:100%;border:none" class="table  table-borderless table-hover">
  <thead>
    <tr>
      <td scope="col"><input type="checkbox" name="vehicle1" value="Bike"></td>
      <td scope="col">Leads</td>
      <td scope="col">Activities</td>
      <td scope="col">Proposals</td>
      <td scope="col">Contracts</td>
      <td scope="col">Deals</td>
      <td  style="width:17%" scope="col">
        <div  class="icons-hidden">
                  <i style="position: absolute;z-index: 1;right: 2%;top: 7%; " class="fas fa-search"  ></i>
        </div>
        <b-input class="icons-hidden" placeholder="search"></b-input></td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><input type="checkbox" name="vehicle1" value="Bike"></td>
      <td style="color:#21A6D1">kickers</td>
      <td>---</td>
      <td>Proposal No. 275  <b-progress :value="20"></b-progress> 
      </td>

      <td >---</td>
      <td style="color:green" >Invoice No:79</td>
      <td class="icons-hidden" style="font-size:16px;padding-left:5%" ><i class="fas fa-envelope"></i> &nbsp; &nbsp; &nbsp; &nbsp;<i class="far fa-trash-alt"></i>&nbsp; &nbsp; &nbsp; &nbsp;<i class="fas fa-print"></i></td>
       <!-- <td style="font-size:16px;padding-left:42%" class="icon-show"><i class="fas fa-ellipsis-v"></i></td> -->



    </tr>
    <tr>
      <td><input type="checkbox" name="vehicle1" value="Bike"></td>
      <td style="color:#21A6D1">kickers</td>
      <td>---</td>
      <td>Proposal No. 275</td>
      <td >---</td>
      <td style="color:green">Invoice No:79</td>
      <td class="icons-hidden" style="font-size:16px;padding-left:5%" ><i class="fas fa-envelope"></i> &nbsp; &nbsp;&nbsp; &nbsp; <i class="far fa-trash-alt"></i>&nbsp; &nbsp; &nbsp; &nbsp;<i class="fas fa-print"></i></td>
       <!-- <td style="font-size:16px;padding-left:42%" class="icon-show"><i class="fas fa-ellipsis-v"></i></td> -->
    </tr>
    <tr>
      <td><input type="checkbox" name="vehicle1" value="Bike"></td>
      <td style="color:#21A6D1">kickers</td>
      <td>---</td>
      <td>Proposal No. 275</td>
      <td >---</td>
      <td style="color:green">Invoice No:79</td>
      <td class="icons-hidden" style="font-size:16px;padding-left:5%" ><i class="fas fa-envelope"></i> &nbsp; &nbsp; &nbsp; &nbsp;<i class="far fa-trash-alt"></i>&nbsp; &nbsp; &nbsp; &nbsp;<i class="fas fa-print"></i></td>
       <!-- <td style="font-size:16px;padding-left:42%" class="icon-show"><i class="fas fa-ellipsis-v"></i></td> -->

    </tr>
     <tr>
      <td><input type="checkbox" name="vehicle1" value="Bike"></td>
      <td style="color:#21A6D1">kickers</td>
      <td>---</td>
      <td>Proposal No. 275</td>
      <td >---</td>
      <td style="color:green">Invoice No:79</td>
      <td class="icons-hidden" style="font-size:16px;padding-left:5%" ><i class="fas fa-envelope"></i> &nbsp; &nbsp;&nbsp; &nbsp; <i class="far fa-trash-alt"></i>&nbsp; &nbsp; &nbsp; &nbsp;<i class="fas fa-print"></i></td>
       <!-- <td v-on:click="show =!show" style="font-size:16px;padding-left:42%" class="icon-show"><i class="fas fa-ellipsis-v"></i></td> -->

    </tr>
    
  </tbody>
</table>
   <!-- <div><i class="fas fa-envelope"></i> &nbsp; &nbsp; &nbsp; &nbsp;<i class="far fa-trash-alt"></i>&nbsp; &nbsp; &nbsp; &nbsp;<i class="fas fa-print"></i></div> -->
  
</div>
<div class="icon-show">
    <span>Send mail</span>  <i class="fas fa-envelope"></i> &nbsp; &nbsp; &nbsp; &nbsp;<span>Delete</span><i class="far fa-trash-alt"></i>&nbsp; &nbsp; &nbsp; &nbsp;<span>Print</span><i class="fas fa-print"></i>
</div>
</div>
</template>
<style >
.icon-show
{
  display: none;
}
.proposals
{
    height: 300px;
    width: 99%;
    border: 1px solid #ccc;
    margin-left: 2%;
    margin-top: 1%;
    position: relative;
    overflow: scroll;

}
.unfinishedprojects
{
    height: 300px;
    overflow: scroll;
    width: 75.4%;
    border: 1px solid #ccc;
    margin-left: 2%;
    display: inline-block
}
.hdr 
{
  background-color: #ECECEC;
    height: 32px;
    font-size: 16;
    width: 100%;
}

.pendingprojects
{
    height: 298px;
    width: 21%;
    border: 1px solid #ccc;
    border-top: none;
    margin-left: 1.7%;
    display: inline-block;
    position: absolute;
    background-color: white;


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
@media screen and (max-width:414px)
{
  .unfinishedprojects
{
    display: inline;
    margin-right: 11%;
    height: 300px;


    position: unset;
}
.pendingprojects
{
    height: 300px;
    width: 87%;
    margin-left: 7%;
    position: unset;
}
.proposals
{
    height: 300px;
    width: 96%;
    border: 1px solid #ccc;
    margin-left: 2%;
    margin-top: 1%;
    position: unset;
    overflow: scroll;

}
.table-rspnsv
{
    width: 88%;
   
    margin-left: 0.5%;
}

.icon-show
{
  display: block;
}
.icons-hidden
{
  display: none; 
  color: red;
}

}

</style>

<script>

export default {
  
}
</script>