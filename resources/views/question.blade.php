@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Questions</div>

                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Questions</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach ($questions as $questions)
                                <tr>
                                    <td>{{ $questions->questions }}</td>
                                    <td>
                                        <a href="#" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal{{$questions->id}}">Update</a>
                                        <a href="{{ route('questions.destroy', $questions->id) }}" type="button" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                               
                        </tbody>
                    </table>
                </div>   
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add</button>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div>
            <form action="{{ route('addquestions') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="questions" class="form-label">Add Question</label>
                    <input class="form-control" id="question" name="questions" aria-describedby="emailHelp">
                </div>
            
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
    </div>
  </div>
</div>




<div class="modal fade" id="updateModal{{$questions->id}}" tabindex="-1" aria-labelledby="updateModal" aria-hidden="true">
  <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <form action="{{ route('questions.update', $questions->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="questions" class="form-label">Add Question</label>
                            <input class="form-control" id="question"  id="questions{{ $questions->id }}" name="questions" value="{{ $questions->questions }}" aria-describedby="emailHelp">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
  </div>
</div> 

