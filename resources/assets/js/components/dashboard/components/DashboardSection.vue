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
<div class="proposals">
   <table id="scroll" style="width:100%;height:100%;border:none" class="table  table-borderless table-hover">
  <thead>
    <tr>
      <td scope="col"><input type="checkbox" name="vehicle1" value="Bike"></td>
      <td scope="col">Leads</td>
      <td scope="col">Activities</td>
      <td scope="col">Proposals</td>
      <td scope="col">Contracts</td>
      <td scope="col">Deals</td>
      <td style="width:17%" scope="col"><i style="position: absolute;z-index: 1;right: 2%;top: 7%;" class="fas fa-search"></i><b-input placeholder="search"></b-input></td>


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
      <td style="font-size:16px;padding-left:5%" ><i class="fas fa-envelope"></i> &nbsp; &nbsp; &nbsp; &nbsp;<i class="far fa-trash-alt"></i>&nbsp; &nbsp; &nbsp; &nbsp;<i class="fas fa-print"></i></td>



    </tr>
    <tr>
      <td><input type="checkbox" name="vehicle1" value="Bike"></td>
      <td style="color:#21A6D1">kickers</td>
      <td>---</td>
      <td>Proposal No. 275</td>
      <td >---</td>
      <td style="color:green">Invoice No:79</td>
      <td style="font-size:16px;padding-left:5%" ><i class="fas fa-envelope"></i> &nbsp; &nbsp;&nbsp; &nbsp; <i class="far fa-trash-alt"></i>&nbsp; &nbsp; &nbsp; &nbsp;<i class="fas fa-print"></i></td>

    </tr>
    <tr>
      <td><input type="checkbox" name="vehicle1" value="Bike"></td>
      <td style="color:#21A6D1">kickers</td>
      <td>---</td>
      <td>Proposal No. 275</td>
      <td >---</td>
      <td style="color:green">Invoice No:79</td>
      <td style="font-size:16px;padding-left:5%" ><i class="fas fa-envelope"></i> &nbsp; &nbsp; &nbsp; &nbsp;<i class="far fa-trash-alt"></i>&nbsp; &nbsp; &nbsp; &nbsp;<i class="fas fa-print"></i></td>

    </tr>
     <tr>
      <td><input type="checkbox" name="vehicle1" value="Bike"></td>
      <td style="color:#21A6D1">kickers</td>
      <td>---</td>
      <td>Proposal No. 275</td>
      <td >---</td>
      <td style="color:green">Invoice No:79</td>
      <td style="font-size:16px;padding-left:5%" ><i class="fas fa-envelope"></i> &nbsp; &nbsp;&nbsp; &nbsp; <i class="far fa-trash-alt"></i>&nbsp; &nbsp; &nbsp; &nbsp;<i class="fas fa-print"></i></td>

    </tr>
    
  </tbody>
</table>
   
</div>

</div>
</template>
<style >
.proposals
{
    height: 300px;
    width: 97%;
    border: 1px solid #ccc;
    margin-left: 2%;
    margin-top: 1%;
    position: relative;

}
.unfinishedprojects
{
    height: 300px;
    width: 74%;
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
    height: 300px;
    width: 21%;
    border: 1px solid #ccc;
    border-top: none;
    margin-left: 2%;
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
    width: 80%;
    margin-left: 18%;
    position: unset;
}
.proposals
{
    height: 300px;
    width: 97%;
    border: 1px solid #ccc;
    margin-left: 2%;
    margin-top: 1%;
    position: unset;

}
.table-rspnsv
{
    width: 88%;
   
    margin-left: 13.5%;
}
}

</style>

<script>

export default {
  
}
</script>