<template>
    <div class="container" style="background-color:#fff;padding:3%">
        <h3 style="font-size:21px;margin-bottom:32px">New Contract</h3>
           <div class="columns is-12">
            <div class="column is-10"></div>
           <div class="column is-1">
               <b-button type="is-info"><i class="fas fa-save"></i>&nbsp Save</b-button>
           </div>
           <div  class="column is-1">
               <b-button type="is-danger" style="margin-right:2%"><i class="fas fa-ban"></i>&nbsp Cancel</b-button>
           </div>
        </div>
        <div class="columns is-12" style="border-bottom: solid 1px lightgray;padding-bottom: 28px;">
            <h4 style="color:#9A9A9A;border-bottom:#solid 1px #000;margin-left:3%">Contract Data</h4>
        </div>

        <div class="columns is-12" style="margin-top:10px;padding-bottom:15px">
          <div class="column is-1"></div>
            <div class="column is-5">
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
                    <i class="fas fa-plus" style="float:right;cursor:pointer"></i> 
                </div>
                <draggable  @start="drag=true" @end="drag=false"  group="contract"  ghost-class="ghost"> 
                </draggable>

            </div>

            <div class="column is-6">
                <h3 style="text-align:center">Contract Sections</h3>
                <draggable  @start="drag=true" @end="drag=false"  group="contract"  ghost-class="ghost"> 
                    
                </draggable>           

            </div>
        </div>

        <div class="columns is-12" style="float:right">
            <div class="column is-10"></div>
           <div class="column is-1">
               <b-button type="is-info"><i class="fas fa-save"></i>&nbsp Save</b-button>
           </div>
           <div  class="column is-1">
               <b-button type="is-danger" style="margin-right:2%"><i class="fas fa-ban"></i>&nbsp Cancel</b-button>
           </div>
        </div>

    </div>
</template>

<style>
.ghost {
  opacity: 0.2;
  background-color: #7ad0f8;
}
</style>

<script>
import Vue from 'vue'
import draggable from 'vuedraggable'

export default {
      data() {
        return {
             contracts:[{
                newContract:''
            }],
        }
      },
    components: {
        draggable
    },
  methods: {
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
        }
  }
}
</script>