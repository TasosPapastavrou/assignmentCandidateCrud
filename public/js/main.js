var url = window.location.origin;


var candidateTable = $('#candidate-table').DataTable({
    scrollY:        "600px",
    scrollX:        true,
    scrollCollapse: true,
    // dom: "Bflrtip",  
    paging: true,
    serverSide: true,
    processing: true,
    columns: [ 
        { data: "lastName" }, 
        { data: "firstName" }, 
        { data: "email" },
        { data: "mobile" }, 
        { data: "jobAppliedFor" }, 
        { 
            data: "id",
            render: function(data,type,row){
                return '<div class="d-flex flex-row"><div class="col-6"><a class="mr-1 text-decoration-none btn btn-primary" href="'+url+'/edit/candidate/'+data+'">edit</a></div> <div class="col-6"><a class="text-decoration-none btn btn-danger" href="'+url+'/delete/candidate/'+data+'">delete</a></div></div>';
            }                
        }, 
    ],
    ajax: {
        url: url+'/get/candidate/datatables',
        type: "POST", 
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), 
        },
    },
});







$(document).ready(function() {

    var url = window.location.origin;

    if($( "#oldDegreeType" ).val()){
        var oldDegreeType = $( "#oldDegreeType" ).val(); 
    }

    if($('#oldDegreeType').length>0){

        $.ajax({
            url: url+'/get/degrees',
            data: {
                'degree':oldDegreeType
            },
            success: function(results){
                
                let data = results['data'];
                let selected = results['selected'];
                
                if(selected)
                    data.unshift({id: -1, text: '', selected: 'selected', search:'', hidden:true });
                
                var degreeTypes = $('.degree--types').select2({
                    width: '100%',
                    placeholder: {
                        id: "-1",
                        text: "Select Degree Type",
                        selected:'selected'
                    },
                    data: data,
                });
            }

        })

    }





    if($( "#oldJobType" ).val()){
        var oldJobType = $( "#oldJobType" ).val(); 
    }

    if($('#oldJobType').length>0){

        $.ajax({
            url: url+'/get/job/applied',
            data: {
                'job':oldJobType
            },
            success: function(results){
                
                let data = results['data'];
                let selected = results['selected'];
                
                if(selected)
                    data.unshift({id: -1, text: '', selected: 'selected', search:'', hidden:true });
                
                var jobTypes = $('.job--types').select2({
                    width: '100%',
                    placeholder: {
                        id: "-1",
                        text: "Select Degree Type",
                        selected:'selected'
                    },
                    data: data,
                });
            }

        })

    }





    $('#deleteBtn').on('click',function() {
        var id = $(this).attr('data-candidate-id'); // Replace with your actual file name

        $.ajax({
            url: '/delete-pdf/' + id,
            type: 'GET',
            success: function(response) {

                if(response){
                    $('#cv-field').css('display','none');
                }
                else{
                    console.log("error")
                }
                
            }
        });
    });


});









