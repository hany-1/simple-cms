@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">{{ __('Tags') }}</h3>
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="ms-auto">
                                <a href="{{route('admin.tags.create')}}" class="btn btn-primary font-weight-bolder">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                    {{ __('Add Tag') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <table id="tag-table" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <td>{{__('Actions')}}</td>
                                        <td>{{__('Name')}}</td>
                                        <td>{{__('Created At')}}</td>
                                        <td>{{__('Modified At')}}</td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var table = $('#tag-table').DataTable({
            ajax: {
                ajax: "{{route('admin.tags.index')}}",
            },
            processing: true,
            serverSide: true,
            order: [
                [2, 'desc']
            ],
            paging: true,
            ordering: true,
            columns: [{
                    data: 'Actions',
                    responsivePriority: -1,
                    orderable: false,
                    width: "15%"
                },
                {
                    data: 'name',
                    searchable: true,
                    orderable: false,
                },
                {
                    data: 'converted_created_at',
                    searchable: false,
                    orderable: true,
                },
                {
                    data: 'converted_updated_at',
                    searchable: false,
                    orderable: true,
                },
            ],
            columnDefs: [{
                targets: 0,
                title: 'Actions',
                orderable: false,
                searchable: false,
                render: function(data, type, full, meta) {
                    var editUrl = Helper.route("{{route('admin.tags.edit',':1')}}", [full.id]);
                    var editBtn = Helper.editHtmlBtn(editUrl);
                    var deleteBtn = Helper.deleteHtmlBtn(full.id);

                    return editBtn + " " + deleteBtn;
                },
            }],
        });

        $('#tag-table').on('click', '.deleteBtn', function() {
            if (confirm("Delete tag?")) {
                //using axios or jquery way to handle delete post function
                var id = $(this).data('id');
                var datatable = $('#tag-table').DataTable();

                axios.delete(Helper.route("{{route('admin.tags.destroy', ':1')}}", [id])).then(response => {
                    alert(response.data.message);
                    datatable.ajax.reload();
                }).catch(error => {
                    alert(Helper.responseErrorMessage(error));
                });
            }
        });
    });
</script>
@endsection