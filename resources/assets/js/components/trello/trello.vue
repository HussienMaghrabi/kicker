<template>
    <div class="container">
        <div class="columns is-12">
            <!-- <div class="column is-3">
                <ul class="list1">
                    <li><a href="#"><i class="fas fa-border-all"></i> Boards</a></li>
                    <li><a href="#"><i class="fas fa-home"></i> Home </a></li>
                    <li  ><a href="#">TEAMS<i v-on:click="seen=!seen"  class="fas fa-plus add"></i></a></li>
                </ul>
                <a class="team"> <i class="fas fa-user-friends"></i>TEAM-ROUTE</a>
                <ul class="list2">
                    <li><a><i class="far fa-heart"></i>Highlights</a></li>
                    <li><a><i class="fas fa-border-all"></i>All team boards</a></li>
                    <li><a><i class="fas fa-user-friends"></i>Members</a></li>
                    <li><a><i class="fas fa-cog"></i>Settings</a></li>
                </ul>
            </div> -->
            <div class="column is-9 parent">
                <div class="boards"><i class="far fa-user"></i> <h1 style="display:inline">Your Team Boards</h1></div>
                
                   <router-link to="/admin/vue/trelloTasks">
                       <div class="tasks">
                             <h3 class="task">Tasks</h3>
                       </div>
                </router-link> 
                <router-link to="/admin/vue/trelloTasks">
                       <div class="tasks">
                             <h3 class="task">Tasks</h3>
                       </div>
                </router-link>  <router-link to="/admin/vue/trelloTasks">
                       <div class="tasks">
                             <h3 class="task">Tasks</h3>
                       </div>
                </router-link>  <router-link to="/admin/vue/trelloTasks">
                       <div class="tasks">
                             <h3 class="task">Tasks</h3>
                       </div>
                </router-link> 
                <div class="tasks" style="background-color:#ebecf1;color:#4a7625;text-align:center;"> 
                    <p> Create new board </p>
                </div>
            </div>
        </div>
        <div class="add-team" v-if="!seen">
            <p class="c1"> Create Team <i  class="fas fa-times"></i></p>
            <hr>
            <label>Name</label>
            <input>
            <label>Description (optional)</label>
            <textarea></textarea>
            <button>Create</button>
            <p>A team is a group of boards and people. Use it to organize your company, side hustle, family, or friends.</p>
            <p>Business Class gives your team more security, administrative controls, and unlimited Power-Ups.<a href="#"> Learn More.</a></p>
        </div>



        
    </div>
</template>
<style>
    .list1
    {
        margin-top: 30px;
    }
    .list1 li a
    {
        text-decoration: none;
        color: black !important;
        padding: 40px;
        font-weight: bold;
        font-size: 14px;
    }
    .list1 li
    {
        padding-bottom: 15px;

    }
    .list2 li a
    {
       text-decoration: none;
        color: gray !important;
        padding: 40px;
        font-size: 14px;
        margin-left: 30px;
    }
    .list2 li
    {
      padding-bottom: 15px;

    }
    .list2 li a i
    {
        padding-right: 5px;
    }
    /* .team
    {
        padding: 40px;
        font-size: 14px;
        color: #0079bf;
        font-weight: bold;
    } */
    .team i
    {
        padding-right: 5px;
        color: black;
        margin-bottom: 20px;
    }
    .add
    {
        margin-left: 30px;
    }
    .tasks
    {
        /* margin-top: 30px; */
        display: flex;
        height: 100px;
        width: 180px;
        position: relative;
        flex-direction: column;
        justify-content: space-between;
        background-color: #4a7625;
        margin-bottom: 5px;
        display: inline-block;
        font-weight: bold;
    }
    .boards
    {
        color: black ;
        margin-top: 30px;
    }
    .boards i
    {
        color: black !important;
        padding-right: 10px;
         padding-bottom: 10px;
    }
   .tasks
   {
      color: white;
      padding: 10px;
      font-weight: bold;
   }
   .parent
   {
     position: relative;
   }

   .create p 
   {
     padding-top: 45px;
   }
   .add-team
   {
       /* display: none; */
       /* visibility: hidden; */
       color: black;
       width: 300px;
       font-size: 14px;
       border: solid 2px rgba(9,30,66,.04);
   }
   .add-team i
   {
       /* padding-left: 100px !important; */
       float: right;
       padding: 3px;
   }
   .add-team .c1
   {
       padding-left: 60px;
   }
   .add-team input
   {
       width: 90%;
       height: 35px;
       margin-left: 5px;
   }
   .add-team textarea
   {
       width: 90%;
       height: 50px;
       margin-left: 5px;
   }
   .add-team p,label
   {
       padding-left: 5px;
       padding-bottom: 10px;
   }
   .add-team button
   {
           background-color: #49852e;
            box-shadow: none;
            border: none;
            color: #fff;
            height: 30px;
            width: 70px;
            margin: auto;
            margin-left: 5px;
   }
</style>
<script>
export default {
     data() 
           {
            return {
                seen:true,
            }
            },
  
}
</script>