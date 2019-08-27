<template>
<section class="container competitors">
    <b>Competitors</b><hr>
    <div class="add">
        <button name="add" class="btnAdd">Add</button><br>
        <div class="search">
            <label>Search: </label>
            <input type="text" class="inputSearch">
        </div>
    </div>

        <b-table
            :data="data"
            ref="table"
            detailed
            hoverable
            custom-detail-row
            :opened-detailed="['Board Games']"
            :default-sort="['name', 'asc']"
            detail-key="name"
            @details-open="(row, index) => $toast.open(`Expanded ${row.name}`)"
            :show-detail-icon="showDetailIcon">

            <template slot-scope="props">
                <b-table-column
                    field="id"
                    :visible="columnsVisible['id'].display"
                    :label="columnsVisible['id'].title"
                    width="300"
                    sortable
                >
                  {{ props.row.id }}
                </b-table-column>

                <b-table-column
                    field="name"
                    :visible="columnsVisible['name'].display"
                    :label="columnsVisible['name'].title"
                    sortable
                    centered
                >
                    {{ props.row.name }}
                </b-table-column>

                <b-table-column
                    field="facebook"
                    :visible="columnsVisible['facebook'].display"
                    :label="columnsVisible['facebook'].title"
                    sortable
                    centered
                >
                    {{ props.row.facebook }}
                </b-table-column>

                <b-table-column
                    field="show"
                    :visible="columnsVisible['show'].display"
                    :label="columnsVisible['show'].title"
                    sortable
                    centered
                >
                  <b-button type="is-info">                                     
                        <router-link :to="'/admin/vue/competitors_Show/'+props.row.id" style="color:#fff;">
                            Show
                        </router-link>
            </b-button>
                </b-table-column>


                <b-table-column
                    field="edit"
                    :visible="columnsVisible['edit'].display"
                    :label="columnsVisible['edit'].title"
                    sortable
                    centered
                >
                  <b-button type="is-warning" @click="isComponentModalActive = true">Edit</b-button>

        
                <b-modal :active.sync="isComponentModalActive" has-modal-card>
                    <modal-form v-bind="formProps"></modal-form>
                </b-modal>

                </b-table-column>


                <b-table-column
                    field="delete"
                    :visible="columnsVisible['delete'].display"
                    :label="columnsVisible['delete'].title"
                    sortable
                    centered
                >
                <b-button @click="DeleteFromIndex" type="is-danger">Delete</b-button>
                </b-table-column>
            </template>

           
        </b-table>

        <h5>Showing 1 to 1 of 1 entries</h5>
    </section>
</template>

<style>
  .btnAdd{
    background-color: #00a65a;
    color: #fff;
    border: none;
    width: 50px;
    height: 30px;
    float: right;
    margin-bottom: 5PX;
  }
  .search{
      float: right;
  }
  .add{
   float: right;
  }
  .inputSearch{
    height: 30px;
    margin-bottom: 10PX;
  }
  .competitors{
      background-color: #fff;
      padding: 1% !important;
  }
  body{
      background-color: #ECF0F3;
  }
  .modal .animation-content {
    width:40%;
  }
  .switch:hover input[type=checkbox]:checked + .check{
      background: #118fe4;
  }
  .label
  {
      float: left;
  }
  .switch{
      float: left;
  }
</style>

<script>
const ModalForm = {
        template:`
        <form action="">
            <div class="modal-card" style="width: auto">
                <header class="modal-card-head">
                    <p class="modal-card-title">Edit</p>
                </header>
                <section class="modal-card-body">
                    <b-field label="Arabic Name">
                        <b-input
                            type="text"
                            :value="name"
                            required>
                        </b-input>
                    </b-field>

                    <b-field label="English Name">
                        <b-input
                            type="text"
                            :value="name"
                            required>
                        </b-input>
                    </b-field>

                    <b-field label="Facebook">
                        <b-input
                            type="text"
                            :value="Facebook"
                            required>
                        </b-input>
                    </b-field>
                    
                      <div class="field">
                            <b-switch v-model="isSwitchedCustom"
                                true-value="Yes"
                                false-value="No">
                                {{ isSwitchedCustom }}
                            </b-switch>
                      </div><br><br>

                    <b-field label="Notes">
                        <b-input maxlength="200" type="textarea"></b-input>
                    </b-field>
                    
                </section>
                <footer class="modal-card-foot">
                    <button class="button" type="button" @click="$parent.close()">Close</button>
                     <b-button type="is-info">Submit</b-button>
                </footer>
            </div>
        </form>
    `
    }

    export default {
        components: {
        ModalForm,
    },
    data() {
        return {
            data: [
                {
                    name: 'Board Games',
                    sold: 131,
                    available: 301,
                    items: [
                        {
                            name: 'Monopoly',
                            sold: 57,
                            available: 100
                        },
                        {
                            name: 'Scrabble',
                            sold: 23,
                            available: 84
                        },
                        {
                            name: 'Chess',
                            sold: 37,
                            available: 61
                        },
                        {
                            name: 'Battleships',
                            sold: 14,
                            available: 56
                        }
                    ]
                },
                {
                    name: 'Jigsaws & Puzzles',
                    sold: 88,
                    available: 167,
                    items: [
                        {
                            name: 'World Map',
                            sold: 31,
                            available: 38
                        },
                        {
                            name: 'London',
                            sold: 23,
                            available: 29
                        },
                        {
                            name: 'Sharks',
                            sold: 20,
                            available: 44
                        },
                        {
                            name: 'Disney',
                            sold: 14,
                            available: 56
                        }
                    ]
                },
                {
                    name: 'Books',
                    sold: 434,
                    available: 721,
                    items: [
                        {
                            name: 'Hamlet',
                            sold: 101,
                            available: 187
                        },
                        {
                            name: 'The Lord Of The Rings',
                            sold: 85,
                            available: 156
                        },
                        {
                            name: 'To Kill a Mockingbird',
                            sold: 78,
                            available: 131
                        },
                        {
                            name: 'Catch-22',
                            sold: 73,
                            available: 98
                        },
                        {
                            name: 'Frankenstein',
                            sold: 51,
                            available: 81
                        },
                        {
                            name: 'Alice\'s Adventures In Wonderland',
                            sold: 46,
                            available: 68
                        }
                    ]
                }
            ],
            columnsVisible: {
                id: { title: 'ID', display: true },
                name: { title: 'Name', display: true },
                facebook: { title: 'Facebook', display: true },
                show: { title: 'Show', display: true },
                edit: { title: 'Edit', display: true },
                delete: { title: 'Delete', display: true },
            },
            showDetailIcon: true,
            isComponentModalActive: false,
            isSwitched: false,
            isSwitchedCustom: 'Yes'
        }
    },
    methods: {
        toggle(row) {
            this.$refs.table.toggleDetails(row)
        },
        // delete model 
            DeleteFromIndex(id) {
                this.$dialog.confirm({
                    title: 'Deleting ',
                    message: 'Are you sure you want to <b>delete</b> Delete?',
                    confirmText: 'Delete',
                    type: 'is-danger',
                    hasIcon: true,
                    // onConfirm: () => this.deleteThisResale(id)
                })
            },
    }
}
</script>