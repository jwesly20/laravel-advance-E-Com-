@extends('backend.layout.master')

@section('title', 'Fee Entry')
@section('content')

<div class="">
    <h4 class="box-title">Fee Add</h4>
</div>

<form action="{{route("student.fees.store")}}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label>Year <span class="text-danger">*</span> </label>

                <select name="year_id" id="year_id" class="form-control">
                    <option disabled selected>Select Year</option>

                    @foreach ($year as $year)
                    <option value="{{ $year->id }}">{{ $year->year }}</option>
                    @endforeach
                </select>

                @error('year_id')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label>Class <span class="text-danger">*</span> </label>


                <select name="class_id" id="class_id" class="form-control">
                    <option disabled selected>Select Class</option>

                    @foreach ($allclass as $allclass)
                    <option value="{{ $allclass->id }}">{{ $allclass->class_name }}</option>
                    @endforeach
                </select>


                @error('class_id')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>


        <div class="col-md-3">
            <div class="form-group">
                <label>Fee Type <span class="text-danger">*</span> </label>


                <select name="fee_category_id" id="fee_category_id" class="form-control">
                    <option disabled selected>Select Fee Type</option>

                    @foreach ($feeCate as $cate)
                    <option value="{{ $cate->id }}">{{ $cate->fee_cata_name }}</option>
                    @endforeach
                </select>


                @error('fee_category_id')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label>Date <span class="text-danger">*</span> </label>


                <input type="date" class="form-control" name="date" id="date" >

                @error('date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror



            </div>
        </div>









        <div class="col-md-2">
            <div class="form-group">

                <br>
                <h4 class="btn btn-primary btn-sm btn-rounded mt-2" id="search">Search</h4>





            </div>
        </div>



    </div>
<hr>
    <h2>Student List</h2>

    <div class="table-responsive">
        <table id="" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Id No</th>
                    <th>Name</th>
                    <th>Father's Name</th>
                    <th>Orginal Fee</th>
                    <th>Discount Fee (%)</th>
                    <th>Fee (This student)</th>
                    <th>Pay Amount</th>

                </tr>
            </thead>
            <tbody id="tbody">



            </tbody>

        </table>

        <input type="submit" value="Submit" id="add_mark" class="btn btn-primary d-none">
    </div>

</form>


<script>
    $(document).ready(function () {
    $('#search').on('click', function () {

        var yearId = $('#year_id').val();
        var classId = $('#class_id').val();

        var feeCategoryId = $('#fee_category_id').val();
        var date = $('#date').val();

    $.ajax({
       method: 'get',
           url: "{{ url('stufees/search') }}",
           dataType: 'json',
           data: {
               yearId: yearId,
                 classId: classId,
                 feeCategoryId:feeCategoryId,

               },

            success: function(data){
             if(data){



// empty service table befor load
                $('#tbody').empty();


                $.each(data.allStu, function (i, item) {

                    var discount = (data.feeInfo.fee_amount/100)*item.discount_info.discount;
                        $('<tr>').html(

                             "<td> " +item.student.id_no + "</td>" +
                             "<td>" + item.student.name + "</td>"+
                        "<td>  " + item.student.fname + " </td>" +
                        "<td>  " + data.feeInfo.fee_amount + " </td>"+

                          "<td>  " +  item.discount_info.discount + " </td>"+
                       "<td>  " + (data.feeInfo.fee_amount-discount) + " </td>"+
                     "<td> "+
                    "<input type='hidden' name='student_id[]' value='"+item.student.id+"'>"+
                    "<input type='text' name='amount"+item.student.id+"' value='"+(data.feeInfo.fee_amount-discount)+"'>"+

                             "</td>"
                        ).appendTo('#tbody');
                        });

                        $("#add_mark").removeClass('d-none');

             }else{
                 alert ("Please select year,class, group and shift");
             }
          }

    });


    })
});
</script>

@endsection
