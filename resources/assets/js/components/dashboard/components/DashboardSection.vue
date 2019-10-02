<template>
<div> 
  <div class="unfinishedprojects">
    <table id="scroll" style="width:100%;height:100%;border:none" class="table  table-borderless table-hover">
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
<div class="proposals">
   
</div>
</div>
</template>
<style >
.unfinishedprojects
{
   height: 300px;
    width: 74%;
    border: 1px solid #ccc;
    /* border-top: none; */
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
</style>

<script>

export default {
  
}
</script>