@extends('admin.index')

@section('content')
<br>
<br>
<br>
<br>
<style>
.view{
    position: fixed;
    right: -600px;
    top: 0;
    z-index: 100;
    height: 100vh;
    width: 100%;
    max-width: 600px;
    padding: 10px 15px 20px;
    background-color: #ffffff;
    -webkit-box-shadow: 0 4px 15px 1px rgba(113, 106, 202, .2);
    -moz-box-shadow: 0 4px 15px 1px rgba(113, 106, 202, .2);
    box-shadow: 0 4px 15px 1px rgba(113, 106, 202, .2);
    transition: all .3s ease-in-out;
    border-left: 5px solid #b07d12;
    overflow-x: scroll;
}
.message{
    width:80%;
    margin-top:50px;
}
.alert-box {
    z-index:99999;
    padding: 10px 20px;
    border: 1px solid #f09898;
    position:fixed;
    width:600px;
    right: -600px;
}
</style>



<div id="emailsTable">
<modal_send v-bind:text="selected_number" 
            v-bind:aclass="modalClass"
></modal_send>
    <button type="button" class="btn btn-primary" v-on:click="send_all">Send Cil To All Selected</button>

    <table class="table datatable table-striped table-bordered  dt-responsive nowrap "style="width:100%">
        <thead>
            <tr>
            <th>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" v-model="check_all" v-on:click="checkAll($event)"  id="checkAll_teams">
                        <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                    </label>
                </div>
            </th>
                <th>ID</th>
                <th>Lead Name</th>
                <th>Sender Name</th>
                <th>Project</th>
                <th>Devoleper</th>
                <th>View</th>
                <th>Options</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody >
            @if($cils->count() > 0)
                @foreach($cils as $cil)
                    <tr>
                        <td class="checkbox">
                                    <input type="hidden" name="id" value="{{ $cil->id }}">
                            <label>
                                    <input class="switch_teams"  value="{{ $cil->id }}" v-model="checkedItems" name="checked_cils[]" id="checked_cils" type="checkbox" >
                                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                            </label>
                        </td>
                        <td>{{$cil->id}}</td>
                        <td>{{@$cil->lead->first_name ." ".@$cil->lead->last_name}}</td>
                        <th>{{@$cil->user->name}}</th>
                        <td>{{@$cil->project->en_name}}</td>
                        <td>{{@$cil->developer->en_name}}</td>
                        <td><i aria-hidden="true" v-on:click="view({{$cil->id}},this)" class="fa fa-eye"></i></td>
                        <td>
                        <select class="form-control"  onchange="if(this.value=='del'){$('#delete$lead->id').modal('show');} else{location = this.value;}">
                            <option value="#" disabled selected >Options</option>
                            <option value="{{ url(adminPath() . '/cils/' . $cil->id . '/show/') }}">{{ trans('admin.show') }} </option>
                            <option value="{{ url(adminPath() . '/leads/' . @$cil->lead->id .'/edit/') }}">{{ trans('admin.edit') }} </option>
                            <option value="del" class="btn btn-danger btn-flat">{{ trans('admin.delete') }} </option>
                        </select>
                        </td>
                        <td>
                        <select class="form-control"  v-on:change="choose_action( {{ $cil->id }} )">
                            <option value="not_sent" disabled @if($cil->status=="not_sent") selected @endif>Not Sent</option>
                            <option value="WDR" @if($cil->status=="not_sent") disabled @endif @if($cil->status=="WDR") selected @endif>Waiting Devoleper Replay</option>
                            <option value="clean_lead" @if($cil->status=="not_sent") disabled @endif @if($cil->status=="clean_lead") selected @endif>Clean lead</option>
                            <option value="WOB" @if($cil->status=="not_sent") disabled @endif @if($cil->status=="WOB") selected @endif >With Other Broker</option>
                        </select>
                        </td>
                    </tr>
                    <div id="delete{{ $cil->id }}" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">{{ trans('admin.delete') . ' ' . trans('admin.resale_unit') }}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>{{ trans('admin.delete') . ' ' . $cil->name }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            {!! Form::open(['method'=>'DELETE','route'=>['resale_units.destroy',$cil->id]]) !!}
                                            <button type="button" class="btn btn-default btn-flat" data-dismiss="modal">{{ trans('admin.close') }}</button>
                                            <button type="submit" class="btn btn-danger btn-flat">{{ trans('admin.delete') }}</button>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>

                                </div>
                    </div>
                @endforeach
            @else
                <tr>
                    <td colspan="4">No Requests found</td>
                </tr>
            @endif
        </tbody>
    </table>
        {{ $cils->links() }}
    <div v-bind:style="styleView" id="view" class="view">
        <div id="message" class="message" v-html="message">
        </div>
        <br>
        <div>
            <button v-on:click="sendSingle" class="btn btn-large btn-success">Sent</button>
            <form :action="url" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="cilId" :value="cilId">
                <button v-on:click="downloadExcel" class="btn btn-large btn-success">Download</button>
            </form>
        </div>
        
    </div>
    <flash_message v-bind:text="return_message"
                   v-bind:style="return_style"
    >
    </flash_message>
</div>

@endsection
@section('js')
<script>


        // Define a new component called button-counter
        Vue.component('flash_message', {
            props:['text','style'],
        template: '<div class="alert-box" v-bind:style="style">@{{text}}</div>'
        });
        var modal_send=Vue.component('modal_send', {
            props:['text','aclass'],
        template: `
                <div class="modal" v-bind:class="aclass" tabindex="-1" role="dialog" id="mailsModal">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button @click="close_modal" type="button" class="close" ><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Send Mails</h4>
                    </div>
                    <div class="modal-body">
                        <p>Send Emails To (@{{ text }}) Devoleper</p>
                    </div>
                    <div class="modal-footer">
                        <button @click="close_modal" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button :disabled="text == 0" @click="sendAll"type="button" class="btn btn-primary">Send</button>
                    </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->  
        `
        ,methods:{
            close_modal:function(){
                    document.getElementById('mailsModal').style.display="none";
                    app.modalClass={
                        fade:true,
                        "fade-in":false
                    }
            },
            sendAll:function(){
                    axios.post('{{url(adminPath()."/cils/action")}}',
                        {
                            type:"send",
                            cilId:app.checkedItems,
                        }
                        ).then((response)=>{
                            this.close_modal();
                            if(response.data==1){
                                app.return_message="Emails Send Sucessfully. ";
                                app.return_style.right="0px";
                            }else{
                                app.return_message="Faild Send Emails.";
                                app.return_style.right="0px";
                                app.return_style.background="#f19b9b";
                            }
                        })
                        .catch((err)=>{
                            this.close_modal();
                        app.return_message="Faild Send Emails.";
                        app.return_style.right="0px";
                    });
            },
        }
        });
        
         var app= new Vue({
            el:"#emailsTable",
            data:{
                styleView:{
                    right:"-600px",
                },
                viewCollapsed:0,
                checked: [],
                message:'',
                cilId:[],
                i: 0,
                return_message:"",
                return_style:{
                    right:"-600",
                    background:"#008000",
                    "border-color":"#111",
                },
                selected_number:0,
                checkedItems:[],
                modalClass:{
                    fade:true,
                    "fade-in":false,
                },
                check_all:false,
                url: window.location.href + '/export_xsl'
            },
            methods:{
                checkAll:function(event){
                    checkboxes = document.getElementsByName('checked_cils[]');
                    this.checkedItems=[];
                    if(event.target.checked){
                        for(var i=0, n=checkboxes.length;i<n;i++) {
                            this.checkedItems.push(checkboxes[i].value);
                        }
                    }
                        
                },
                view:function(id){
                  if(this.viewCollapsed==0){
                   this.styleView.right="0px";
                   this.viewCollapsed=1;
                   this.cilId=[id];
                   axios.get('{{url(adminPath()."/cils")}}/'+id+'/showVie').then(response => {this.message = response.data});
                  }else{
                   this.styleView.right="-600px";
                   this.viewCollapsed=0;
                  }
                },
                sendSingle:function(){
                    axios.post('{{url(adminPath()."/cils/action")}}',
                        {
                            type:"send",
                            cilId:this.cilId,
                        }
                        ).then(function(response){

                            if(response.data=="1"){
                                app.return_message="Email Send Sucessfully. ";
                                app.return_style.right="0px";
                            }else{
                                app.return_message="Faild Send Email.";
                                app.return_style.right="0px";
                                app.return_style.background="#f19b9b";
                            }
                        })
                        .catch(function(err){
                        app.return_message="Faild Send Email.";
                        app.return_style.right="0px";
                    });
                },
                send_all:function(){
                    this.selected_number=this.checkedItems.length;
                    document.getElementById('mailsModal').style.display="block";
                    this.modalClass={
                        fade:false,
                        "fade-in":true
                    }
                },choose_action:function(id,value){
                axios.post('{{url(adminPath()."/cils/action")}}',
                    {
                        type:"deskEdit",
                        data:$('#sortableDesk').sortable("toArray"),
                    }).then(function(response){
                    console.log(response);
                    })
                    .catch(function(err){
                        console.log(err);
                    });
                },
                downloadExcel:function(e){
                    // e.preventDefault()
                    // axios.post('{{url(adminPath()."/cils/export_xsl")}}',
                    //     {
                    //         cilId:this.cilId,
                    //     }
                    //     ).then(function(response){
                    //         console.log(response);
                    //         if(response.data=="1"){
                    //             app.return_message="Email Send Sucessfully. ";
                    //             app.return_style.right="0px";
                    //         }else{
                    //             app.return_message="Faild Send Email.";
                    //             app.return_style.right="0px";
                    //             app.return_style.background="#f19b9b";
                    //         }
                    //     })
                    //     .catch(function(err){
                    //     app.return_message="Faild Send Email.";
                    //     app.return_style.right="0px";
                    // });
                },

            }
        });
        $('.datatable').dataTable({
            dom: 'Bfrtip',
            responsive: true,
            'paging': false,
            'buttons': [
                {
                    extend: 'print',
                    text: 'Print all'
                },
                {
                    extend: 'print',
                    text: 'Print selected',
                    exportOptions: {
                        modifier: {
                            selected: true
                        }
                    }
                }
                ],
            stateSave: true,
            'lengthChange': false,
            'searching': true,
            'ordering': true,
            'info': true,
            "order": [[ 0, "desc" ]],
            'autoWidth': true
        });

</script>
@endsection