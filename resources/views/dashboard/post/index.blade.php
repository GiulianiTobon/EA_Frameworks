@extends('dashboard.master')
@section('content')
<a class="btn btn-success mt-3 mb-3" href="{{ route('post.create') }}">Crear</a>

<table class="table">
    <thead>
        <tr>
            <td scope="col">ID</td>
            <td scope="col">Nombre</td>
            <td scope="col">Categoría</td>
            <td scope="col">Posteado</td>
            <td scope="col">Creación</td>
            <td scope="col">Actualización</td>
            <td scope="col">Acciones</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($posts as $post )
            <tr>
                <td>
                    {{ $post->id }}
                </td>
                <td>
                    {{ $post->title }}                    
                </td>
                <td>
                    {{ $post->category_id }}
                </td>
                <td>
                    {{ $post->posted }}
                </td>
                <td>
                    {{ $post->created_at->format('d-m-y') }}
                </td>
                <td>
                    {{ $post->update_at->format('d-m-y') }}
                </td>
                <td>
                    <a href="{{ route('post.show',$post->id) }}" class="btn btn-primary">Ver</a>
                    <a href="{{ route('post.edit',$post->id) }}" class="btn btn-primary">Actualizar</a>

                    <button data-toggle="modal" data-target="#deleteModal" data-id="{{ $post->id }}" class="btn btn-outline-danger">Eliminar</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $posts->links()}}

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-tittle" id="modalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>¿Seguro que desea borrar el registro seleccionado?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                <form id="formDelete" method="POST" action="{{ route('post.destroy'),0 }}" data-action="{{ route('post.destroy',0) }}">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger">Borrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    window.onload = function(){
        $('#deleteModal').on('show.bs.modal',function(event){
            var button = $(event.relatedTarget)
            var id = button.data('id')
            action = $('#formDelete').attr('data-action').slice(0,-1)
            action += id
            $('#formDelete').attr('action', action)
            var modal = $(this)
            modal.find('.modal-title').text('Vas a borrar el POST: '+id)
        });
    };
</script>
