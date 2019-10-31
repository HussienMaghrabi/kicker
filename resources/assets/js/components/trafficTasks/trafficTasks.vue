<template>
  <div class="body"> 
  <div class="section1">
        <p>Kickers</p>
        <i class="far fa-star"></i>
        <button class="team">Private Team
            <button class="free">free</button>
        </button>
        <button class="vsbl"><i class="fas fa-user-friends"></i>Team Visible</button>
        <img class="profile" src="/images/s-33756__340.png" />
        <img class="profile" src="/images/s-33756__340.png" />
        <img class="profile" src="/images/s-33756__340.png" />
        <img class="profile" src="/images/s-33756__340.png" />
        
        <button class="invite">invite</button>
        <button v-on:click="seen = !seen" class="show"> <i class="fas fa-ellipsis-h"></i>Show Menu</button>
 </div>
 <div class="columns is-12 web-site" >
 <!-- <vuescroll :ops="ops"> -->
  <draggable  class=" column is-12" ghost-class="trans">
     
    <div  class="column is-2 itemm1" style="display:inline-block" >
        <p class="title">Doneee1 <i v-on:click="showww = !showww" class="fas fa-ellipsis-h"> </i></p>
        <draggable :list="list" group="drag-item" @start="drag=true" @end="drag=false" class="column is-12 " ghost-class="trans">
            
        <div v-on:click="ModalActive = !ModalActive" class="sub-div ">
             <p > Click Me </p>
        </div>
        <div class="sub-div ">
               <p>Exam 4</p>
        </div>
        
        </draggable>

        <div>
            <p  v-on:click="anothercard1 = !anothercard1"> <i class="fas fa-plus add"></i> Add another card  </p>
        </div>
         <div v-if="anothercard1" class="add-another-card1">
            <input placeholder="Enter a title for this card...">
            <button>Add Card</button> <i v-on:click="anothercard1 = !anothercard1" class="fas fa-times"></i>
            <i v-on:click="options1 = !options1" class="fas fa-ellipsis-h"> </i>
            <div v-if="options1" class="optionss1">
                <h2 class="actions"> Options1 <i v-on:click="options1 = !options1" class="fas fa-times"></i></h2>
                <hr>
                <ul>
                    <li class="listt"><a href="#"> Members... </a></li>
                    <li class="listt"><a href="#"> Lables... </a></li>
                    <li class="listt"><a href="#"> Positions...</a></li>
                </ul>
           </div>

        </div>
        <div v-if="showww"  class="dots-menu1">
    <h2 class="actions"> List Actions1 <i v-on:click="showww = !showww" class="fas fa-times"></i></h2>
    <hr>
    <ul>
        <li v-on:click="anothercard1 = !anothercard1;showww = false" class="listt"><a href="#"> Add Card... </a></li>
        <li class="listt"><a href="#">Copy List... </a></li>
        <li class="listt"><a href="#"> Move List...</a></li>
        <li class="listt"><a href="#"> Watch</a></li>
        <hr>
        <li class="listt"><a href="#"> Sort By...</a></li>
        <li class="listt"><a href="#">Move All Cards in This List</a></li>
        <li class="listt"><a href="#">Archive All Cards in This List</a></li>
        <hr>
        <li class="listt"><a href="#">Archive This List</a></li>
    </ul>
</div>

    </div>
     
    <div class="column is-2 itemm2" style="display:inline-block">
        <p class="title">Doing2 <i v-on:click="showw = !showw" class="fas fa-ellipsis-h"> </i></p>
        <draggable group="drag-item" :list="list" @start="drag=true" @end="drag=false" class="column is-12" ghost-class="trans">
        <div class="sub-div ">
             <p>Exam 1 </p>
        </div>
        <div class="sub-div ">
               <p>Exam 2</p>
        </div>
        
        </draggable>
        <div>
            <p   v-on:click="anothercard2 = !anothercard2"> <i class="fas fa-plus add"></i> Add another card  </p>
        </div>
        <div v-if="anothercard2" class="add-another-card2">
            <input placeholder="Enter a title for this card...">
            <button>Add Card</button> <i v-on:click="anothercard2 = !anothercard2" class="fas fa-times"></i>
            <i v-on:click="options2 = !options2" class="fas fa-ellipsis-h"> </i>
            <div v-if="options2" class="optionss2">
                <h2 class="actions"> Options2 <i v-on:click="options2 = !options2" class="fas fa-times"></i></h2>
                <hr>
                <ul>
                    <li class="listt"><a href="#"> Members... </a></li>
                    <li class="listt"><a href="#"> Lables... </a></li>
                    <li class="listt"><a href="#"> Positions...</a></li>
                </ul>
           </div>

        </div>

    <div v-if="showw" class="dots-menu2">
    <h2 class="actions"> List Actions2 <i v-on:click="showw = !showw" class="fas fa-times"></i></h2>
    <hr>
    <ul>
        <li v-on:click="anothercard2 = !anothercard2;showw = false" class="listt"><a href="#"> Add Card... </a></li>
        <li class="listt"><a href="#">Copy List... </a></li>
        <li class="listt"><a href="#"> Move List...</a></li>
        <li class="listt"><a href="#"> Watch</a></li>
        <hr>
        <li class="listt"><a href="#"> Sort By...</a></li>
        <li class="listt"><a href="#">Move All Cards in This List</a></li>
        <li class="listt"><a href="#">Archive All Cards in This List</a></li>
        <hr>
        <li class="listt"><a href="#">Archive This List</a></li>
    </ul>
</div>

    </div>
    <div class="column is-2 itemm3" style="display:inline-block"> 
        <p class="title">To-Do3 <i v-on:click="show = !show" class="fas fa-ellipsis-h"> </i></p>
        <draggable group="drag-item" :list="list" @start="drag=true" @end="drag=false" class="column is-12" ghost-class="trans">
        <div class="sub-div ">
             <p>Exam 3 </p>
        </div>
        <div class="sub-div ">
               <p>Exam 5</p>
        </div>
        
        </draggable>
        <div>
            <p v-on:click="anothercard3 = !anothercard3"> <i class="fas fa-plus add"></i> Add another card  </p>
        </div>
        <div v-if="anothercard3" class="add-another-card3">
            <input placeholder="Enter a title for this card...">
            <button>Add Card</button> <i v-on:click="anothercard3 = !anothercard3" class="fas fa-times"></i>
            <i v-on:click="options3 = !options3" class="fas fa-ellipsis-h"> </i>
            <div v-if="options3" class="optionss3">
                <h2 class="actions"> Opitons3 <i v-on:click="options3 = !options3" class="fas fa-times"></i></h2>
                <hr>
                <ul>
                    <li class="listt"><a href="#"> Members... </a></li>
                    <li class="listt"><a href="#"> Lables... </a></li>
                    <li class="listt"><a href="#"> Positions...</a></li>
                </ul>
           </div>

        </div>


        <div v-if="show" class="dots-menu3">
    <h2 class="actions"> List Actions3 <i v-on:click="show = !show" class="fas fa-times"></i></h2>
    <hr>
    <ul>
        <li v-on:click="anothercard3 = !anothercard3;show = false" class="listt"><a href="#"> Add Card... </a></li>
        <li v-on:click="copylist = !copylist;show=false" class="listt"><a href="#">Copy List... </a></li>
        
        <li v-on:click="movelist = !movelist;show=false" class="listt"><a href="#"> Move List...</a></li>
        <li class="listt"><a href="#"> Watch</a></li>
        <hr>
        <li class="listt"><a href="#"> Sort By...</a></li>
        <li class="listt"><a href="#">Move All Cards in This List</a></li>
        <li class="listt"><a href="#">Archive All Cards in This List</a></li>
        <hr>
        <li class="listt"><a href="#">Archive This List</a></li>
    </ul>
</div>
<div class="copylist" v-if="copylist">
            <h3 style="display:inline;padding:9px">Copy List</h3><i v-on:click="copylist = !copylist" style="float:right;padding:7px;" class="fas fa-times"></i>
            <hr>
            <h3>Name</h3>
            <textarea style="display:block ;height: 50px; width: 80% ;margin-bottom: 4px;"></textarea>
            <button style="background-color:#5aac44;color:white;margin:7px;height:35px">Create List</button>
        </div>

    </div>
    <div class="movelist" v-if="movelist">
        <h3 style="display:inline;padding:9px">Move List</h3> <i v-on:click="movelist = !movelist" style="float:right;padding:7px;" class="fas fa-times"></i>
        <hr>
        <label>Board</label>
        <b-field >
            <b-select expanded>
                <option>Kickers</option>
            </b-select>
        </b-field>
        <label>Position</label>
        <b-field >
            <b-select expanded>
                <option>1</option>
            </b-select>
        </b-field>
        <button style="background-color:#5aac44;color:white;margin:7px;height:35px">Move</button>
    </div>
    <div class="column is-2 itemm another-list" style="display:inline-block">
        <div>
            <p v-on:click="anotherlist = !anotherlist"> <i class="fas fa-plus add"></i> Add another list  </p>
           
        </div>
        <div v-if="anotherlist" class="add-another-list">
            <input placeholder="Enter list title...">
            <button>Add List</button> <i v-on:click="anotherlist = !anotherlist" class="fas fa-times"></i>

        </div>

    </div>
  </draggable>
 <!-- </vuescroll> -->
    
</div>
<div v-if="seen" class="menu">
    <h2> Menu <i v-on:click="seen = !seen" class="fas fa-times"></i></h2>
    <hr>
    <ul>
        <li><i class="fas fa-border-all"></i><a href="#">About This Board </a></li>
        <p>Add a description to your board</p>
        <li><i class="fas fa-square"></i> <a href="#">Change Background </a></li>
        <li><i class="fas fa-search"></i><a href="#"> Search Cards </a></li>
        <li><i class="far fa-sticky-note"></i><a href="#"> Stickers </a></li>
        <li><i class="fas fa-ellipsis-h"> </i><a href="#"> More </a></li>
        <hr>
        <li><i class="fas fa-location-arrow"></i><a href="#"> Power-Ups </a></li>
        <li><i class="fas fa-plus add"></i><a href="#">Add Power-Up</a></li>
        <li><i class="fas fa-tasks"></i><a href="#">Activity</a></li>

    </ul>
</div>

 <vue-custom-scrollbar class="scroll-area"  :settings="settings" @ps-scroll-X="scrollHanle">
<div class=" mobile">
<draggable >

       <div class=" itemm1 item" style="display:inline-block" >
        <p class="title">Doneee1 <i v-on:click="showww = !showww" class="fas fa-ellipsis-h"> </i></p>
        <draggable :list="list" @start="drag=true" @end="drag=false" class="column is-12">
         <div v-on:click="ModalActive = !ModalActive" class="sub-div ">
             <p > Click Me </p>
        </div>
        <div class="sub-div ">
               <p>Exam 2</p>
        </div>
        
        </draggable>

        <div>
            <p  v-on:click="anothercard1 = !anothercard1"> <i class="fas fa-plus add"></i> Add another card  </p>
        </div>
         <div v-if="anothercard1" class="add-another-card1">
            <input placeholder="Enter a title for this card...">
            <button>Add Card</button> <i v-on:click="anothercard1 = !anothercard1" class="fas fa-times"></i>
            <i v-on:click="options1 = !options1" class="fas fa-ellipsis-h"> </i>
            <div v-if="options1" class="optionss1">
                <h2 class="actions"> Options1 <i v-on:click="options1 = !options1" class="fas fa-times"></i></h2>
                <hr>
                <ul>
                    <li class="listt"><a href="#"> Members... </a></li>
                    <li class="listt"><a href="#"> Lables... </a></li>
                    <li class="listt"><a href="#"> Positions...</a></li>
                </ul>
           </div>

        </div>
        <div v-if="showww" class="dots-menu1">
    <h2 class="actions"> List Actions1 <i v-on:click="showww = !showww" class="fas fa-times"></i></h2>
    <hr>
    <ul>
        <li class="listt"><a href="#"> Add Card... </a></li>
        <li class="listt"><a href="#">Copy List... </a></li>
        <li class="listt"><a href="#"> Move List...</a></li>
        <li class="listt"><a href="#"> Watch</a></li>
        <hr>
        <li class="listt"><a href="#"> Sort By...</a></li>
        <li class="listt"><a href="#">Move All Cards in This List</a></li>
        <li class="listt"><a href="#">Archive All Cards in This List</a></li>
        <hr>
        <li class="listt"><a href="#">Archive This List</a></li>
    </ul>
</div>

    </div>
  
    <div class="column is-6 itemm2 item" style="display:inline-block"> 
        <p class="title">Doing2 <i v-on:click="showw = !showw" class="fas fa-ellipsis-h"> </i></p>
        <draggable :list="list" @start="drag=true" @end="drag=false" class="column is-12">
        <div class="sub-div ">
             <p>Exam 1 </p>
        </div>
        <div class="sub-div ">
               <p>Exam 2</p>
        </div>
        <div class="sub-div ">
              <p>Exam 3</p>
        </div>
        </draggable>
        <div>
            <p   v-on:click="anothercard2 = !anothercard2"> <i class="fas fa-plus add"></i> Add another card  </p>
        </div>
        <div v-if="anothercard2" class="add-another-card2">
            <input placeholder="Enter a title for this card...">
            <button>Add Card</button> <i v-on:click="anothercard2 = !anothercard2" class="fas fa-times"></i>
            <i v-on:click="options2 = !options2" class="fas fa-ellipsis-h"> </i>
            <div v-if="options2" class="optionss2">
                <h2 class="actions"> Options2 <i v-on:click="options2 = !options2" class="fas fa-times"></i></h2>
                <hr>
                <ul>
                    <li class="listt"><a href="#"> Members... </a></li>
                    <li class="listt"><a href="#"> Lables... </a></li>
                    <li class="listt"><a href="#"> Positions...</a></li>
                </ul>
           </div>

        </div>

    <div v-if="showw" class="dots-menu2">
    <h2 class="actions"> List Actions2 <i v-on:click="showw = !showw" class="fas fa-times"></i></h2>
    <hr>
    <ul>
        <li  class="listt"><a href="#"> Add Card... </a></li>
        <li class="listt"><a href="#">Copy List... </a></li>
        <li class="listt"><a href="#"> Move List...</a></li>
        <li class="listt"><a href="#"> Watch</a></li>
        <hr>
        <li class="listt"><a href="#"> Sort By...</a></li>
        <li class="listt"><a href="#">Move All Cards in This List</a></li>
        <li class="listt"><a href="#">Archive All Cards in This List</a></li>
        <hr>
        <li class="listt"><a href="#">Archive This List</a></li>
    </ul>
</div>

    </div>
    <div class="column is-12 itemm3 item" style="display:inline-block"> 
        <p class="title">To-Do3 <i v-on:click="show = !show" class="fas fa-ellipsis-h"> </i></p>
        <draggable :list="list" @start="drag=true" @end="drag=false" class="column is-12">
        <div class="sub-div ">
             <p>Exam 1 </p>
        </div>
        <div class="sub-div ">
               <p>Exam 2</p>
        </div>
        <div class="sub-div ">
              <p>Exam 3</p>
        </div>
        </draggable>
        <div>
            <p v-on:click="anothercard3 = !anothercard3"> <i class="fas fa-plus add"></i> Add another card  </p>
        </div>
        <div v-if="anothercard3" class="add-another-card3">
            <input placeholder="Enter a title for this card...">
            <button>Add Card</button> <i v-on:click="anothercard3 = !anothercard3" class="fas fa-times"></i>
            <i v-on:click="options3 = !options3" class="fas fa-ellipsis-h"> </i>
            <div v-if="options3" class="optionss3">
                <h2 class="actions"> Opitons3 <i v-on:click="options3 = !options3" class="fas fa-times"></i></h2>
                <hr>
                <ul>
                    <li class="listt"><a href="#"> Members... </a></li>
                    <li class="listt"><a href="#"> Lables... </a></li>
                    <li class="listt"><a href="#"> Positions...</a></li>
                </ul>
           </div>

        </div>


        <div v-if="show" class="dots-menu3">
    <h2 class="actions"> List Actions3 <i v-on:click="show = !show" class="fas fa-times"></i></h2>
    <hr>
    <ul>
        <li class="listt"><a href="#"> Add Card... </a></li>
        <li class="listt"><a href="#">Copy List... </a></li>
        <li class="listt"><a href="#"> Move List...</a></li>
        <li class="listt"><a href="#"> Watch</a></li>
        <hr>
        <li class="listt"><a href="#"> Sort By...</a></li>
        <li class="listt"><a href="#">Move All Cards in This List</a></li>
        <li class="listt"><a href="#">Archive All Cards in This List</a></li>
        <hr>
        <li class="listt"><a href="#">Archive This List</a></li>
    </ul>
</div>

    </div>
     
    <div class="column is-12 itemm another-list item" style="display:inline-block">
        <div>
            <p v-on:click="anotherlist = !anotherlist"> <i class="fas fa-plus add"></i> Add another list  </p>
           
        </div>
        <div v-if="anotherlist" class="add-another-list">
            <input placeholder="Enter list title...">
            <button>Add List</button> <i v-on:click="anotherlist = !anotherlist" class="fas fa-times"></i>

        </div>

    </div>
  </draggable>


</div>
  </vue-custom-scrollbar>
            <div v-if="ModalActive" class="modall ">
                <div class=" columns is-12 ">
                    <div class="column is-8">
                        <p><i class="fas fa-credit-card"></i> HR </p>
                        <p>in list task1</p>
                        <h3>Members</h3>
                        <h3><i style="padding-right:7px;" class="fas fa-align-left"></i>Description</h3>
                        <button v-on:click="description = !description">Add a more detailed description...</button>
                        <div class="desc" v-if="description">
                            <textarea placeholder="Add a more detailed description..."></textarea>
                            <button style="background-color:#5aac44;display:inline;color:white">Save</button><i style="margin-left:10px;" v-on:click="description = !description" class="fas fa-times"></i>
                            <button style="display:inline;float:right">Formatting help</button>
                        </div>
                        <h3 style="display:inline"><i style="padding-right:7px;" class="fas fa-tasks"></i>Activity</h3>
                        <button style="display:inline; float:right">Show Detailes</button>
                        <input v-on:click="comment = !comment" v-if="comment==false" style="display:block" placeholder="write a comment...">
                        <div v-if="comment" class="comment">
                            <textarea style="display:block" placeholder="write a comment..."> </textarea>
                            <button style="display:inline;margin-left:7px">Save</button>
                            <i style="margin-left:10px;" v-on:click="comment = !comment" class="fas fa-times"></i>
                                    <i class="fas fa-paperclip"></i>
                                    <i class="fas fa-at"></i>
                                    <i class="far fa-smile"></i>
                                    <i class="fas fa-credit-card"></i>
                                
                        </div>
                    </div>
                    <div class="column is-4">
                        <h3 style="display:inline">Add to card</h3><i style="float:right;" v-on:click="ModalActive = !ModalActive" class="fas fa-times"></i>
                        <ul>
                            <li v-on:click="member = !member"><i class="far fa-user"></i><a href="#" >Members</a></li>
                               <div class="member" v-if="member">
                                    <h4 style="display:inline;">Members</h4><i  v-on:click="member = !member" class="fas fa-times"></i>
                                    <hr>
                                    <input placeholder="Search members">
                                    <p style=" font-size:12px !important">BOARD MEMBERS</p>
                                    <img class="profile" src="/images/s-33756__340.png" />
                                    <h3 style="display:inline;" >Somaya Adel</h3>
                               </div>
                            <li v-on:click="label = !label" ><i class="fas fa-tag"></i><a href="#" >Labels</a></li>
                                <div class="labeel" v-if="label">
                                    <i style="float:right;padding:7px;" v-on:click="label = !label" class="fas fa-times"></i>
                                    <hr>
                                    <input style="margin-left:4px" placeholder="Search Labels...">
                                    <p style="font-size:12px">LABELS</p>
                                    <div style="background-color:#61be4f" class="sub-label"></div><i class="fas fa-pencil-alt"></i>
                                    <div style="background-color:#f2d600" class="sub-label" ></div><i class="fas fa-pencil-alt"></i>
                                    <div style="background-color:#ff9f1b" class="sub-label"></div><i class="fas fa-pencil-alt"></i>
                                    <div style="background-color:#eb5a45" class="sub-label"></div><i class="fas fa-pencil-alt"></i>
                                    <div style="background-color:#c376e0" class="sub-label"></div><i class="fas fa-pencil-alt"></i>
                                    <div style="background-color:#0178bf" class="sub-label"></div><i class="fas fa-pencil-alt"></i>
                                    <button>Create a new label</button>
                                    <hr>
                                    <button>Enable color blind friendly mode</button>

                                </div>
                            <li v-on:click="checklist = !checklist"><i class="far fa-check-square"></i><a href="#" >Checklist</a></li>
                                <div v-if="checklist" class="checklist">
                                    <i style="float:right;padding:7px;" v-on:click="checklist = !checklist" class="fas fa-times"></i>
                                    <hr>
                                    <p>Title</p>
                                    <input style="margin-left:7px" placeholder="checklist"> 
                                    <button style="background-color:#5aac44;color:white;margin:7px;">Add</button>
                                      
                                </div>
                            <li v-on:click="duedate = !duedate"><i class="far fa-clock"></i><a href="#" >Due Date</a></li>
                                <div class="duedate" v-if="duedate"> 
                                    <b-datepicker style="width:80%;display:inline-block"
                                            :show-week-number="showWeekNumber"
                                            placeholder="Click to select..."
                                            icon="calendar-today">
                                    </b-datepicker>  <i style="float:right;padding:7px;padding-top:17px;" v-on:click="duedate = !duedate" class="fas fa-times"></i>
                                    <p>Set Reminder</p>
                                     <b-field >
                                        <b-select >
                                            <option> 1 Day Before</option>
                                        </b-select>
                                    </b-field>
                                    <p>Reminders will be sent to all members and watchers of this card</p>
                                    <button style="background-color:#5aac44;color:white;margin:7px;display:inline;width:75px">Save</button>
                                    <button style="background-color:#cf513d;color:white;margin:7px;display:inline;float:right;width:75px">Remove</button>
                                </div>
                            <li v-on:click="attachment = !attachment"><i class="fas fa-paperclip"></i><a href="#" >Attachment</a></li>
                                <div class="attachment" v-if="attachment">
                                    <i style="float:right;padding:7px;padding-top:17px;" v-on:click="attachment = !attachment" class="fas fa-times"></i>
                                    <hr>
                                    <ul>
                                        <li>Computer</li>
                                        <li>Trello</li>
                                        <li>Google Drive</li>
                                        <li>Dropbox</li>
                                        <li>Box</li>
                                        <li>OneDrive</li>
                                        <hr>
                                        <p>Attach a link</p>
                                        <input placeholder="Paste any link here">
                                        <button>Attach</button>
                                        <p>Tip: With Power-Ups, you can attach conversations from Slack, pull requests from GitHub, and leads from Salesforce.</p>
                                    </ul>
                                </div>
                        </ul>
                        <h3>POWER-UPS</h3>
                        <ul>
                            <li><a href="#" >Get Power-Ups</a></li>
                        </ul>
                        <h3>Actions</h3>
                        <ul>
                            <li v-on:click="move = !move"><i class="fas fa-arrow-right"></i><a href="#" >Move</a></li>
                            <div class="move" v-if="move">
                                <i style="float:right;padding:7px;padding-top:17px;" v-on:click="move = !move" class="fas fa-times"></i>
                                <hr>
                                <p>SELECT DESTINATION</p>
                                <label>Board</label>
                                <b-field >
                                        <b-select expanded>
                                            <option> Kickers</option>
                                        </b-select>
                                </b-field>
                                <label>List</label>
                                <b-field >
                                        <b-select expanded>
                                            <option> Somaya</option>
                                        </b-select>
                                </b-field>
                                <label>Position</label>
                                <b-field >
                                        <b-select expanded>
                                            <option> 1</option>
                                        </b-select>
                                </b-field>
                                <button style="background-color:#5aac44;color:white;margin:7px;"> Move</button>
                            </div>
                            <li><i class="far fa-copy"></i><a href="#" >Copy</a></li>
                            <li><i class="far fa-eye"></i><a href="#" >Watch</a></li>
                            <hr>
                            <li><i class="fas fa-archive"></i><a href="#" >Archive</a></li>
                            <li><i class="fas fa-share-alt"></i><a href="#" >Share</a></li>


                        </ul>
                    </div>

                </div>
            </div>
        
  </div>
  
</template>
<style>
.web-site
{
     padding-left:80px
}
.trans
{
  opacity: 0.3;
  transition: opacity 2s;
}



.copylist
{
     background-color:#ffffff;
    position: absolute;
    left:65%;
    border: rgba(9,30,66,.04) 1px solid;
    top: 30%;
    width: 270px;
    font-size: 14px;
}
.movelist
{
  background-color:#ffffff;
    position: absolute;
    left:50%;
    border: rgba(9,30,66,.04) 1px solid;
    top: 30%;
    width: 270px;
    font-size: 14px;
}
.member
{
    background-color:#ffffff;
    position: absolute;
    right: -70px;
    border: rgba(9,30,66,.04) 1px solid;
    top: 73px;
     text-align: center;
}
.labeel
{
    background-color:#ffffff;
    position: absolute;
    right: -70px;
    border: rgba(9,30,66,.04) 1px solid;
    top: 100px;
    width: 250px;
}
.checklist
{
    background-color:#ffffff;
    position: absolute;
    right: -70px;
    border: rgba(9,30,66,.04) 1px solid;
    top: 140px;
    width: 250px;
}
.duedate
{
    background-color:#ffffff;
    position: absolute;
    right: -70px;
    border: rgba(9,30,66,.04) 1px solid;
    top: 170px;
    width: 250px;
}
.attachment
{
    background-color:#ffffff;
    position: absolute;
    right: -70px;
    border: rgba(9,30,66,.04) 1px solid;
    top: 200px;
    width: 270px;
    font-size: 14px
}
.move
{
       background-color:#ffffff;
    position: absolute;
    right: -70px;
    border: rgba(9,30,66,.04) 1px solid;
    top: 260px;
    width: 270px;
    font-size: 14px
}

.labeel button
{
    background-color: rgb(246, 246, 248);
    width: 80%;
    height: 30px;
}
/* .labeel .fa-pencil-alt
{
    margin-bottom: 5px;
} */
.sub-label
{
   width: 80%;
   height: 36px;
   margin: 4px;
   display:inline-block;
}
.member  .fa-times
{
    float: right;
    padding: 5px;
}
.member input
{
    width: 80%;

}
.profile
{
    
    border-radius: 50%;
    display: inline;
    width: 20px;
    height: 20px;
    background-color: gray;
    margin-top: 3px;
}
.comment textarea
{
    height: 108px;
    width: 100%;
    border-bottom: none;
}
.comment i 
{
    margin: 5px;
}
.desc
{
    margin-bottom: 15px;
}
.desc textarea
{
    height: 108px;
    width: 100%;
}
.modall
{
    background-color:white;
    color: black;
    width: 50%;
    padding: 20px;
    position: absolute;
    top: 17%;
    left: 25%
}
.modall li 
{
    padding: 5px;
    background-color: rgba(9,30,66,.04);
    margin: 5px;
    color: black !important;

}
.modall a 
{
    color: black;
    padding: 5px;
    padding-left: 10px !important;

}
.modall h3 
{
    padding: 5px;
    margin: 5px;
    margin-left: 10px !important ;

}
.modall input
{
    height: 37px;
    background-color: white;
    margin-top: 7px
}
.modall button 
{
    background-color: rgba(9,30,66,.04);
    box-shadow: none;
    border: none;
    border-radius: 3px;
    display: block;
    min-height: 40px;
    padding: 8px 12px;
    text-decoration: none;
    margin-bottom: 7px;
}
.section1 p
{
  display: inline;
  color: white;
  font-weight: bold;
  padding: 10px;
  margin-left: 89px
}
.section1 .fa-star
{
    background-color: #4a7625;
    font-size: 18px;
    color: white;
    padding: 5px;
    height: 34px;
    margin-top: 10px;
}
.body
{
    font-family: -apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Noto Sans,Ubuntu,Droid Sans,Helvetica Neue,sans-serif;
    background-image: url(/images/marvin-ronsdorf-yPnfe61MAF8-unsplash.jpg);
    background-repeat: no-repeat;
    background-size: 100% 100%;
    height: 900px;
    margin-top: 0px !important;
}
.section1 .team
{
     background-color: #56842a;
     color: white;
      border: none;
      box-shadow: none;
      height: 35px;
      margin-top: 10px;
      margin-right: 10px;
      margin-left: 10px;
      padding: 5px
}
.section1 .free
{
    color: white;
    background-color:  #3b5418;
    border-radius: 90%;
    float: right;
    border: none;
    box-shadow: none;
    margin-left: 5px;

}
.vsbl
{
     background-color: #56842a;
     color: white;
      border: none;
      box-shadow: none;
      height: 35px;
      margin-top: 10px;
      margin-right: 10px;
      padding: 5px
}

.vsbl i{
    padding-right: 5px;
}
.invite
{
      background-color: #56842a;
     color: white;
      border: none;
      box-shadow: none;
      height: 35px;
      margin-top: 10px;
      padding: 5px
}
.show
{
    background-color: #56842a;
     color: white;
      border: none;
      box-shadow: none;
      height: 35px;
      margin-top: 10px;
      float: right;
      margin-right: 10px;
}
.show i 
{
        padding-right: 5px;

}
.title
{
  color: black;
  padding: 10px;
  font-size: 18px;
}
.itemm
{
    position: relative;
    background-color: #ebecf1;
    margin-left: 30px;
    margin-top: 30px;
    width: 100px;
}
.itemm1
{
    position: relative;
    background-color: #ebecf1;
    margin-left: 30px;
    margin-top: 30px;
    width: 100px;
}
.itemm1 .add-another-card1 .fa-ellipsis-h
{
    float: right;
    width: 25px;
    padding: 10px;
}
.itemm2 .add-another-card2 .fa-ellipsis-h
{
    float: right;
    width: 25px;
    padding: 10px;
}
.itemm3 .add-another-card3 .fa-ellipsis-h
{
    float: right;
    width: 25px;
    padding: 10px;
}
.itemm1  .fa-ellipsis-h
{
    float: right;
    width: 25px;
}
.itemm1 .fa-ellipsis-h:hover
{
    cursor: pointer;
}
.itemm1 .fa-plus
{
    padding: 5px;
}
.itemm2
{
    position: relative;
    background-color: #ebecf1;
    margin-left: 30px;
    margin-top: 30px;
    width: 100px;
}
.itemm2 .fa-ellipsis-h
{
    float: right;
    width: 25px;

}
.itemm2 .fa-ellipsis-h:hover
{
    cursor: pointer;
}
.itemm2 .fa-plus
{
    padding: 5px;
}
.itemm3
{
    position: relative;
    background-color: #ebecf1;
    margin-left: 30px;
    margin-top: 30px;
    width: 100px;
}
.itemm3 .fa-ellipsis-h
{
    float: right;
    width: 25px;

}
.itemm3 .fa-ellipsis-h:hover
{
    cursor: pointer;
}
.itemm3 .fa-plus
{
    padding: 5px;
}

.another-list
{
    background-color: #56842a;
    color: white;
    height: 50px;
    position: absolute;
}
.menu
{
    position: absolute;
    top: 84.5px;
    right: 0px;
    width: 22%;
    background-color: #ebecf1;
    color: black;
}
.menu h2 
{
    margin-left: 45%;
    font-weight: bold;

}
.menu li a
{
   color: black;
}
.menu li,p
{
     padding: 10px;
}
.menu i
{
    padding: 5px;
}
.menu h2 i 
{
    float: right;
}
.optionss1
{
  position: absolute;
    right: 0px;
    z-index: 10;
    left: 150px;
    top: 50px;
    width: 100%;
    background-color:white;
    color: black;
}
.optionss2
{
  position: absolute;
    right: 0px;
    z-index: 10;
    left: 150px;
    top: 50px;
    width: 100%;
    background-color:white;
    color: black;
}
.optionss3
{
  position: absolute;
    right: 0px;
    z-index: 10;
    left: 150px;
    top: 50px;
    width: 100%;
    background-color:white;
    color: black;
}

.dots-menu1
{
  position: absolute;
    right: 0px;
    z-index: 10;
    left: 150px;
    top: 50px;
    width: 100%;
    background-color:white;
    color: black;
}
.dots-menu2
{
  position: absolute;
    top: 50px;
    left: 150px;
    width: 100%;
    background-color:white;
    color: black;
        z-index: 10;

}
.dots-menu3
{
 position: absolute;
    top: 50px;
    left: 150px;
    width: 100%;
    background-color:white;
    color: black;
        z-index: 10;
}
.listt
{
   padding: 8px;
}
.listt a
{
   color: black;
}
.actions
{
    margin-left: 35%;
    font-weight: bold;
    margin-top: 3px;
}
.actions i
{
    float: right;
    padding: 5px;
}
.add-another-list
{
    background-color: #ebecf1;
    color: black;
    position: absolute;
    top: 0px;
    height: 114px;
    left: 0px;
}
.add-another-list button
{
    background-color: #56842a;
    box-shadow: none;
    border: none;
    color: #fff;
    padding: 10px;
    margin: 3px;
   
}
.add-another-list input
{
    width: 90%;
    height: 50px;
    margin: 5px;
}
.add-another-list i
{
 padding: 10px;
}
.add-another-card1
{
    background-color: #ebecf1;
    color: black;
    position: absolute;
    height: 114px;
    left: 0px;
    top: 100%;
    z-index: 999
}
.add-another-card1 button
{
    background-color: #56842a;
    box-shadow: none;
    border: none;
    color: #fff;
    padding: 10px;
    margin: 3px;
   
}
.add-another-card1 input
{
    width: 90%;
    height: 50px;
    margin: 5px;
}
.add-another-card1 i
{
 margin-right: 15px;
}
.add-another-card2
{
    background-color: #ebecf1;
    color: black;
    position: absolute;
    top: 100%;
    height: 114px;
    left: 0px;
}
.add-another-card2 button
{
    background-color: #56842a;
    box-shadow: none;
    border: none;
    color: #fff;
    padding: 10px;
    margin: 3px;
   
}
.add-another-card2 input
{
    width: 90%;
    height: 50px;
    margin: 5px;
}
.add-another-card2 i
{
  margin-right: 15px;

}
.add-another-card3
{
    background-color: #ebecf1;
    color: black;
    position: absolute;
    top: 100%;
    height: 114px;
    left: 0px;
}
.add-another-card3 button
{
    background-color: #56842a;
    box-shadow: none;
    border: none;
    color: #fff;
    padding: 10px;
    margin: 3px;
   
}
.add-another-card3 input
{
    width: 90%;
    height: 50px;
    margin: 5px;
}
.add-another-card3 i
{
  margin-right: 15px;

}
.fa-times:hover
{
  cursor: pointer;
}
.sub-div
{
    width: 80%;
    margin: auto;
    background-color: white;
    height: 100px;
    margin-top: 5px;
}
.scroll-area 
{
  position: relative;
  margin: auto;
  width: 600px;
  height: 600px;
  margin-top: 100px;
}
@media (max-width: 414px)
{
    .modall
    {
        width: 100%
    }
   .web-site
   {
      display: none;
   }
   .item
   {
       width: 25%;
   }
   .section1
   {
       width: 80%;
   }
   .menu
   {
     width: 60%;
     right: -50%;
     z-index: 9
   }
   .dots-menu1,.optionss1,.optionss2,.optionss3
   {
       left: unset;
   }
   .dots-menu2
   {
       left: unset;
   }
   .dots-menu3
   {
       left: unset;
   }
   .add-another-card1
   {
       z-index: 2;
   }
   .add-another-card2
   {
       z-index: 2;
   }
   .add-another-card3
   {
       z-index: 2;
   }
   .add-another-list
   {
       position: unset;
   }
   .mobile
   {
       width: 200%;
   }
   .body
   {
       width: 150%;
   }

}
@media (min-width: 415px)
{
  
   .mobile
   {
       display: none;
   }
}

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.20.0/vuedraggable.umd.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sortablejs@1.8.4/Sortable.min.js"></script>

<script>
import vuescroll from 'vuescroll';
import $ from 'jquery'
import draggable from 'vuedraggable'
import { Carousel, Slide } from "vue-carousel"
import vueCustomScrollbar from 'vue-custom-scrollbar'

export default {
     head: {
      
     },
     data() 
           {
            return {
                ops: {
          vuescroll: {},
          scrollPanel: {},
          rail: {},
          bar: {}
        },
                ModalActive: false,
                settings: {
        maxScrollbarLength: 60
      },
                seen:false,
                show:false,
                showw:false,
                showww:false,
                anotherlist:false,
                anothercard3:false,
                 anothercard2:false,
                anothercard1:false,
                options1:false,
                options2:false,
                options3:false,
                 isDragging: false,
                 description:false,
                 comment:false,
                 member:false,
                 label:false,
                 checklist:false,
                 duedate:false,
                 attachment:false,
                 move:false,
                 copylist:false,
                 movelist:false

            }
            },
            mounted()
            {              
            },
            methods:
            {
              
            },
            components: {
            draggable,
            Carousel,
            Slide,
            vueCustomScrollbar,
            vuescroll
            
            
        },
        
  

}
    
</script>