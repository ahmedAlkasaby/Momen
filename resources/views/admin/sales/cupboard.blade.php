@extends('admin.master')
@section('name_of_page')
الخازنه
@endsection
@section('content')
<center>
<div class="container">
<div class="card" style="width: 18rem;">
    <div class="card-header">
      Featured
    </div>
    <ul class="list-group list-group-flush">
      <li class="list-group-item">الخازنه</li>
      <li class="list-group-item">الخازنه={{$cupboard}}</li>
      <li class="list-group-item">ارباح الخازنه={{$gains}}</li>
    </ul>
  </div>
</div>
</center>
@endsection
