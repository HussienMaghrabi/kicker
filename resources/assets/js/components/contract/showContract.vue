<template>
    <div class="container" style="background-color:#fff;padding:3%">
        <h3 style="font-size:21px;margin-bottom:32px">Contract</h3>
         
        <div class="columns is-12" style="border-bottom: solid 1px lightgray;padding-bottom: 28px;">
            <h4 style="color:#9A9A9A;border-bottom:#solid 1px #000;margin-left:3%">Contract Data</h4>
        </div>

        <div class="columns is-12" style="margin-top:10px;padding-bottom:15px">
          <div class="column is-1"></div>
            <div class="column is-5">
                 <b-field style="margin-bottom:6%">
                   <label  class="column is-4">Approval Members</label>
                    <img class="profile" src="/images/s-33756__340.png" v-on:click="show = !show"/>
                    <img class="profile" src="/images/s-33756__340.png" v-on:click="show = !show"/>
                    <img class="profile" src="/images/s-33756__340.png" v-on:click="show = !show"/>
                    <img class="profile" src="/images/s-33756__340.png" v-on:click="show = !show"/>  
                </b-field>

                 <div v-if="show" class="columns is-12" style="background-color:whitesmoke">
                    <div class="column is-1"></div>
                    <div class="column is-1"><img src="/images/s-33756__340.png" v-on:click="show = !show"/></div>
                    <div class=" column is-9" style="margin-left:2%"><h2> Christeena </h2>
                        <div>
                            <p>Email : ChriteenaBekheet@gmail.com</p>
                            <p>Position : CEO</p>
                        </div>
                    </div>
                    <div class="column is-2"><i v-on:click="show = !show" class="fas fa-times"></i></div>
                    
                 </div>


                <b-field>
                   <label  class="column is-4">*Proposed Company</label>
                   <div class="select" style="width:100%">
                        <select style="width:100%">
                            <option value="Company" selected>Company</option>
                            <option value="friends">Friends</option>
                            <option value="public">Public</option>
                        </select>
                   </div>
                </b-field>

                <b-field>
                    <label class="column is-4">Lead</label>
                    <div class="select" style="width:100%">
                        <select style="width:100%">
                            <option value="Kickers" selected>Kickers</option>
                            <option value="friends">Friends</option>
                            <option value="public">Public</option>
                        </select>
                    </div>
                </b-field>

               <b-field>
                    <label class="column is-4">Contact</label>
                    <b-select expanded style="margin-right:1%" v-model="newConract">
                        <option value="Contact">Contact</option>
                        <option value="2">Mrs.</option>
                        <option value="3">Ms.</option>
                    </b-select>
                          <span><img src="/images/add.png" style="cursor:pointer;margin-top:5px" @click="addContractField"></span> 
                </b-field>

                <b-field v-if="indexContract > 0" v-for="(contract, indexContract) in contracts" :key="indexContract">
                    <label class="column is-4">Contact</label>
                    <b-select expanded style="margin-right:1%" v-model="newConract">
                        <option value="Contact">Contact</option>
                        <option value="2">Mrs.</option>
                        <option value="3">Ms.</option>
                    </b-select>
                          <span><img src="/images/remove.png" style="cursor:pointer;margin-top:5px" @click="removeContractField(indexContract,contract)"></span> 
                </b-field>

                <b-field>
                    <label class="column is-4">Proposal</label>
                    <div class="select" style="width:100%">
                        <select style="width:100%">
                            <option value="727" selected>727</option>
                            <option value="800">800</option>
                        </select>
                    </div>
                </b-field>

                <b-field>
                    <label  class="column is-4">Contract Date</label>
                    <b-datepicker
                        icon="calendar-today">
                    </b-datepicker>
                </b-field>
            </div>
        </div>

        <div class="columns is-12" style="border-bottom: solid 1px lightgray;padding-bottom: 28px;">
            <h4 style="color:#9A9A9A;border-bottom:#solid 1px #000;margin-left:3%">Contract Sections</h4>
        </div>

        <div class="columns is-12" style="margin-top:4%">
            <div class="column is-6" style="margin-right:2%">
                <h3 style="text-align:center">Available Sections</h3>
                <div style="background-color:#ECECEC;padding:5px;margin-bottom:2%;border:2px solid #e6e6e6">
                    <p style="display:initial">Create New Section</p>
                    <i class="fas fa-plus" style="float:right;cursor:pointer" @click="openModal"></i> 

                    <b-modal :active.sync="isComponentModalActive" has-modal-card>
                        <div class="modal-card" style="width: 400px">
                            <header class="modal-card-head">
                                <p class="modal-card-title">Add New Contract</p>
                            </header>
                            <section class="modal-card-body">
                                <b-field>
                                    <b-input type="textarea"  placeholder="English Section"></b-input>                                 
                                </b-field>
                                 <b-field>
                                    <b-input type="textarea" placeholder="English Section"></b-input>                                 
                                </b-field>
                            </section>
                            <footer class="modal-card-foot">
                                <b-button type="is-info"><i class="fas fa-save"></i>&nbsp Save</b-button>
                                <button class="button" type="button" @click="isComponentModalActive = false">Cancel</button>
                            </footer>
                        </div>
                    </b-modal>

                </div>

                <b-modal :active.sync="isComponentEditContractActive" has-modal-card>
                        <div class="modal-card" style="width: 400px">
                            <header class="modal-card-head">
                                <p class="modal-card-title">Edit This Section</p>
                            </header>
                            <section class="modal-card-body">
                                <b-field>
                                    <b-input type="textarea"></b-input>                                 
                                </b-field>
                                 <b-field>
                                    <b-input type="textarea"></b-input>                                 
                                </b-field>
                            </section>
                            <footer class="modal-card-foot">
                                <b-button type="is-info"><i class="fas fa-edit"></i>&nbsp Update</b-button>
                                <b-button type="is-danger"  icon-left="delete" @click="isComponentEditContractActive = false">Remove</b-button>
                            </footer>
                        </div>
                </b-modal>

                
                <draggable  @start="drag=true" @end="drag=false" group="contract"  ghost-class="ghost" :move="cardMoved">
                <div style="background-color:#ECECEC;padding:5px;margin-bottom:2%;border:2px solid #e6e6e6">
                    <b style="display:initial;margin-left: 44%;border-bottom: 1px #000 solid">البندالأول</b>
                    <i class="fas fa-edit" style="float:right;cursor:pointer" @click="openContractModal"></i> 
                    <p style="text-align:center;margin-top:5%">يعتبرالتمهيد السابق جزء مكمل و متمم لهذا العقد.</p>
                    <b-button type="is-success" style="margin-top:5%"><i class="far fa-thumbs-up"></i>&nbsp Approve</b-button>&nbsp
                    <b-button v-on:click="showComment = !showComment" type="is-danger" style="margin-top:5%"><i class="far fa-comments"></i>&nbsp Comment</b-button>
                </div>

                <div v-if="showComment" style="background-color:#ECECEC;margin-bottom:2%;margin-left:0%" class="columns is-12">
                   <div class="column is-1" style="margin-top:5%"> <img style="width:50px;height:50px;padding: 5px;border-radius: 50%;background-color:#fff" src="/images/s-33756__340.png"/></div>
                   <div class="column is-9">
                       <b-field>
                          <b-input type="textarea" placeholder="Leave a Comment..."></b-input>
                       </b-field>
                   </div>
                   <div class="column is-1"></div>
                   <div class="column is-1">
                       <i v-on:click="showComment = !showComment" class="fas fa-times"></i>
                   </div>
                   <!-- <div class="column is-2">
                       <b-button type="is-info"><i class="fas fa-paper-plane"></i>&nbsp Send</b-button>
                   </div> -->
                </div>

                <div style="background-color:#ECECEC;padding:5px;margin-bottom:2%;border:2px solid #e6e6e6">
                    <b style="display:initial;margin-left: 44%;border-bottom: 1px #000 solid">تمهيد</b>
                    <i class="fas fa-edit" style="float:right;cursor:pointer" @click="openContractModal"></i> 
                    <p style="text-align:center;margin-top:2%">لما كانتالشركة التىيمثلها الطرف الأول تقوم بأعمال تصميم المواقع الإلكترونية وإستضافتهاعلى شبكة</p>
                    <p style="text-align:center;margin-top:2%">الإنترنتوكانت الشركة التى يمثلها الطرف الثانى تحتاج إلى تصميم و/أوإستضافة الموقع الخاصبها على </p>
                    <p style="text-align:center;margin-top:2%">الإنترنتوعمل حساب بريد إلكترونى خاص بها و ذلك من خلال ما هو متاح لدى الطرف الأول,فقدإتفق</p>
                    <p style="text-align:center;margin-top:2%">الطرفان علىأن يقوم الطرف الأول بتصميم و إستضافة الموقع الخاص بالطرف الثانى فى الحدود والشروط</p>
                    <span  style="text-align:center;margin-top:2%">                                 التى يتضمنها هذا العقد</span>
                    <!-- <b-button type="is-success" style="margin-top:5%"><i class="far fa-thumbs-up"></i>&nbsp Approve</b-button>&nbsp
                    <b-button v-on:click="showComment = !showComment" type="is-danger" style="margin-top:5%"><i class="far fa-comments"></i>&nbsp Comment</b-button> -->
                </div>

                

                <div style="background-color:#ECECEC;padding:5px;margin-bottom:2%;border:2px solid #e6e6e6">
                    <b style="display:initial;margin-left: 44%;border-bottom: 1px #000 solid">البندالخامس</b>
                    <i class="fas fa-edit" style="float:right;cursor:pointer" @click="openContractModal"></i> 
                    <p style="text-align:center;margin-top:2%;margin-bottom:5%">العميل مسؤل مسئوليةكاملة عن أي محتوى في المساحة الخاصة له أياً كان من نصوص أو صور أو ملفاتمرئية.... الخ </p>
                    <b style="display:initial;margin-left: 44%;border-bottom: 1px #000 solid;margin-bottom:2%">البند الخامس عشر</b>                    
                    <p style="text-align:center;margin-top:2%">فى حالة حدوث خلاف لا قدر الله بين الطرفين المتعاقدينفإنه يتم اللجوء إلى التحكيم أمام الجهات المختصة </p>
                    <p style="text-align:center;margin-top:2%">دون حاجة إلى اللجوء للقضاء.</p>
                    <p style="text-align:center;margin-top:2%"> ماورد في عرض السعر جزءمكمل و متمم لهذا العقد </p>
                    <span  style="text-align:center;margin-top:2%">                                                      والله خيـــر الشــاهديــــن ..</span>
                </div>

                <div style="background-color:#ECECEC;padding:5px;margin-bottom:2%;border:2px solid #e6e6e6">
                    <b style="display:initial;margin-left: 44%;border-bottom: 1px #000 solid">البند العاشر</b>
                    <i class="fas fa-edit" style="float:right;cursor:pointer" @click="openContractModal"></i> 
                    <p style="text-align:center;margin-top:2%">فى حالة التأخير في دفع قيمة الإستضافة أو تجديدها لمدةخمسة أيام فإنه يتم إيقاف الخدمة مؤقتا ولا يتم إعادتها</p>
                    <p style="text-align:center;margin-top:2%">إلا بعد دفع رسوم قدرها ثلاثمائة جنية مصري مقابل إعادةالفتح و ذلك بالإضافة إلى مبلغ مائة جنية مصري عن</p>
                    <p style="text-align:center;margin-top:2%">كل يوم تأخير. ويتم إلغاء الخدمة نهائيا بعد خمسة عشريوما وبدون أي مسئولية على الطرف الأول.</p>
                </div>

                <div style="background-color:#ECECEC;padding:5px;margin-bottom:2%;border:2px solid #e6e6e6">
                    <b style="display:initial;margin-left: 44%;border-bottom: 1px #000 solid"> البند الخامس عشر</b>
                    <i class="fas fa-edit" style="float:right;cursor:pointer" @click="openContractModal"></i> 
                    <p style="text-align:center;margin-top:2%">فى حالة حدوث خلاف لا قدر الله بين الطرفين المتعاقدينفإنه يتم اللجوء إلى التحكيم أمام الجهات المختصة</p>
                    <p style="text-align:center;margin-top:2%">دون حاجة إلى اللجوء للقضاء.</p>
                    <p style="text-align:center;margin-top:2%"> ماورد في عرض السعر جزءمكمل و متمم لهذا العقد </p>
                    <span  style="text-align:center;margin-top:2%">                                                      والله خيـــر الشــاهديــــن ..</span>
                </div>
                 </draggable>


            </div>
            <div class="column is-6">
                <h3 style="text-align:center">Contract Sections</h3>
            
              <draggable  @start="drag=true" @end="drag=false"  group="contract"  ghost-class="ghost">            
                <div style="background-color:#ECECEC;padding:5px;margin-bottom:2%;border:2px solid #e6e6e6">
                    <b style="display:initial;margin-left: 44%;border-bottom: 1px #000 solid">تمهيد</b>
                    <i class="fas fa-edit" style="float:right;cursor:pointer" @click="openContractModal"></i> 
                    <p style="text-align:center;margin-top:2%">لما كانتالشركة التىيمثلها الطرف الأول تقوم بأعمال تصميم المواقع الإلكترونية وإستضافتهاعلى شبكة</p>
                    <p style="text-align:center;margin-top:2%">الإنترنتوكانت الشركة التى يمثلها الطرف الثانى تحتاج إلى تصميم و/أوإستضافة الموقع الخاصبها على </p>
                    <p style="text-align:center;margin-top:2%">الإنترنتوعمل حساب بريد إلكترونى خاص بها و ذلك من خلال ما هو متاح لدى الطرف الأول,فقدإتفق</p>
                    <p style="text-align:center;margin-top:2%">الطرفان علىأن يقوم الطرف الأول بتصميم و إستضافة الموقع الخاص بالطرف الثانى فى الحدود والشروط</p>
                    <span  style="text-align:center;margin-top:2%">                                 التى يتضمنها هذا العقد</span>
                </div>

                <div style="background-color:#ECECEC;padding:5px;margin-bottom:2%;border:2px solid #e6e6e6">
                    <b style="display:initial;margin-left: 44%;border-bottom: 1px #000 solid">البندالثالث</b>
                    <i class="fas fa-edit" style="float:right;cursor:pointer" @click="openContractModal"></i> 
                    <p style="text-align:center;margin-top:2%">يقدم الطرفالأول نماذج من التصميمات ليختار منها العميل النموذج المطلوب ويحق للعميل طلبتعديلات</p>
                    <p style="text-align:center;margin-top:2%">يكون العميل مسئول مسئولية كاملة عن تقديمالبيانات الصحيحة عنه وكذلك تزويد الطرف الأول بكافة</p>
                    <p style="text-align:center;margin-top:2%">المعلوماتوالمواد المطلوبة لتنفيذ عمله وأي أمور أخرى إضافية مع ضمان تزويد الطرف الأولبالمواد</p>
                    <p style="text-align:center;margin-top:2%">المطلوبةبطريقة تضمن جودة التنفيذ, و يحق للطرف الأول فسخ العقد وإيقاف الخدمة فى حالة عدمصحة</p>
                    <p style="text-align:center;margin-top:2%">البيانات.</p>
                </div>

                <div style="background-color:#ECECEC;padding:5px;margin-bottom:2%;border:2px solid #e6e6e6">
                    <b style="display:initial;margin-left: 44%;border-bottom: 1px #000 solid">البند الثانى</b>
                    <i class="fas fa-edit" style="float:right;cursor:pointer" @click="openContractModal"></i> 
                    <p style="text-align:center;margin-top:2%">يقوم الطرفالأول بتصميم الموقع طبقا لطلبات الطرف الثانى (العميل) و الموضحة تحديدا بالمرفقرقم (1)</p>
                    <p style="text-align:center;margin-top:2%">بقيمةإجمالية قدرها               650     جنية مصري فقط لاغير.</p>
                    <p style="text-align:center;margin-top:2%">و تكون طريقةالسداد كالتالى :</p>
                    <p style="text-align:center;margin-top:2%">- دفعة مقدمةقدرها 60% من إجمالى قيمة العقد فور التوقيع على العقد .</p>
                    <p style="text-align:center;margin-top:2%">-دفعة نهائيةقدرها  40% من إجمالى قيمة العقدفورالموافقة علي تصميم الموقع (صورة واحدة ثابتة لشكل الموقع)</p>
                </div>

                <div style="background-color:#ECECEC;padding:5px;margin-bottom:2%;border:2px solid #e6e6e6">
                    <b style="display:initial;margin-left: 44%;border-bottom: 1px #000 solid">البند الرابع </b>
                    <i class="fas fa-edit" style="float:right;cursor:pointer" @click="openContractModal"></i> 
                    <p style="text-align:center;margin-top:2%">الدعم الفنيمن الطرف الأول مسئول عن مساعدة العميل فى كافة الأعمال التى قام بتنفيذها فقط وأي أعمال</p>
                    <p style="text-align:center;margin-top:2%">لجهات أخرىفإن الطرف الأول غير مسئول عن تقديم أي دعم فني لها.</p>
                </div>

              </draggable>


            </div>
        </div>

    </div>
</template>

<script src="//cdnjs.cloudflare.com/ajax/libs/Vue.Draggable/2.20.0/vuedraggable.umd.min.js"></script>

<script>

import Vue from 'vue'
import draggable from 'vuedraggable'


export default {
    components: {
            draggable

},
data() {
    return {
        isComponentModalActive: false,
        isComponentEditContractActive: false,
        contracts:[{
                newContract:''
            }],
        show:false,
        showComment:false
        }},
mounted() {
},
created() {
    },
methods: {
    openModal(){
        this.isComponentModalActive = true
    },
    openContractModal(){
        this.isComponentEditContractActive = true
    },
    addContractField(){
            this.contracts.push({
            newConract: '',
        });
    },
    removeContractField(indexContract,contract){
        var idx = this.contracts.indexOf(contract);
        console.log(idx, indexContract);
        if (idx > -1) {
            this.contracts.splice(idx, 1);
        }
    },
    // cardMoved:function(event){
    //     console.log("eveeeent",event)
    // }
}
}
</script>

<style>
@media screen and (max-width: 767px)
{
   .field.has-addons 
   {
       display:unset;
   }

}
.ghost {
  opacity: 0.2;
  background-color: #7ad0f8;
}
body{
    color:#000;
}
.profile
{
    border-radius: 50%;
    display: inline;
    width: 30px;
    height: 30px;
    background-color: gray;
    margin-right: 1%;
    cursor: pointer;
}
</style>