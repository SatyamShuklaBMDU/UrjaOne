@extends('include.master')
@section('content')
    <div class="row">
        <div class="col-md-4 mb-sm-4 d-flex flex-wrap align-items-center text-head">
            <h2 class="mb-3 me-auto">Add Wallets Plans</h2>
        </div>
        <div class="col-md-5"></div>
        <div class="col-md-3 mb-sm-4 d-flex flex-wrap align-items-end text-head">
            <a href="{{ route('all-wallet-plans') }}" class="btn btn-primary mb-2 h6"><span class="text-white fw-bold">See Wallets
                    Plans</span></a>
        </div>
    </div>
    <!-- row -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-xl-12 col-xxl-12">
            <div class="card">
                <form class="card-body" action="{{ route('wallet-store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label text-dark fw-bold h5">Plan Name</label>
                        <input type="text" name="name" class="form-control border-dark" id="name"
                            placeholder="Enter Name">
                    </div>
                    <div class="mb-3">
                        <label for="dynamic_field" class="form-label text-dark fw-bold h5">Load and Amount</label>
                        <table class="table table-bordered table-hover" id="dynamic_field">
                            <tr>
                                <td><label for="loadmain" class="form-label text-dark">Load</label><input id="loadmain" type="number" name="load[]" placeholder="Enter your Load"
                                        class="form-control name_list border-dark" /></td>
                                <td><label for="amountmain" class="form-label text-dark">Amount</label><input id="amountmain" type="number" name="amount[]" placeholder="Enter your Amount"
                                        class="form-control name_email border-dark" /></td>
                                <td><button type="button" name="add" id="add" class="btn btn-primary">Add
                                        More</button></td>
                            </tr>
                        </table>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label text-dark fw-bold h5">Plan Image</label>
                        <input type="file" name="image" class="form-control border-dark" id="image">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label text-dark fw-bold h5">Plan Details</label>
                        <textarea name="description" id="description" class="form-control border-dark" cols="30" rows="10"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary h6">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
    </script>
    <script>
        $(document).ready(function() {
            var i = 1;
            var length;
            var addamount = 700;
            $("#add").click(function() {
                i++;
                $('#dynamic_field').append('<tr id="row' + i +
                    '"><td><input type="number" name="load[]" placeholder="Enter your Load" class="form-control name_list border-dark"/></td><td><input type="number" name="amount[]" placeholder="Enter your Amount" class="form-control name_email border-dark"/></td><td><button type="button" name="remove" id="' +
                    i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
            });

            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            CKEDITOR.replace('description', {
                toolbar: [{
                        name: 'basicstyles',
                        items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript',
                            '-', 'RemoveFormat'
                        ]
                    },
                    {
                        name: 'paragraph',
                        items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-',
                            'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight',
                            'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'
                        ]
                    },
                    {
                        name: 'links',
                        items: ['Link', 'Unlink', 'Anchor']
                    },
                    {
                        name: 'styles',
                        items: ['Styles', 'Format', 'Font', 'FontSize']
                    },
                    {
                        name: 'colors',
                        items: ['TextColor', 'BGColor']
                    },
                    {
                        name: 'tools',
                        items: ['Maximize', 'ShowBlocks']
                    },
                    {
                        name: 'document',
                        items: ['Source']
                    }
                ]
            });
        });
    </script>
@endsection
