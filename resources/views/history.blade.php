@extends('layouts.app')

@section('content')
<link href="{{ asset('css/background.css') }}" rel="stylesheet">

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel">
                <div class="panel-heading"><h4>Search History</h4></div>
                <div class="panel-body">
                  <table class="table table-striped task-table">

                  <!-- Table Headings -->
                  <thead>
                      <th>Id</th>
                      <th>Target's name</th>
                      <th>Date</th>
                      <th>&nbsp;</th>
                  </thead>

                  <!-- Table Body -->
                  <tbody id="history_table">
                      @foreach ($search as $s)
                          <tr>
                              <!-- Task Name -->
                              <td class="table-text">
                                  <div>{{ $s->id }}</div>
                              </td>
                              <td class="table-text">
                                  <div>{{ $s->target->name }}</div>
                              </td>
                              <td class="table-text">
                                  <div>{{ $s->created_at }}</div>
                              </td>

                              <td>
                                <form action="{{ url('profile/history/'.$s->id) }}" method="GET">
                                  {{ csrf_field() }}

                                  <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-trash"></i> Detail
                                  </button>
                                </form>
                              </td>
                          </tr>
                      @endforeach
                  </tbody>
              </table>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

@endsection
