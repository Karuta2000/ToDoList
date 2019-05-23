@foreach ($columns->chunk(4) as $chunk)
<div class="row">
   @foreach ($chunk as $item)
   <div class="col-md-3 mb-3">
      <div class="card shadow-sm">
         <div class="card-header">{{ $item->name }}
            <div class="float-right">
               <a onclick="add(this)" href="#"><i class="fas fa-plus mr-1"></i></a>
               <i class="fas fa-pen mr-1"></i>
               <i class="fas fa-trash-alt"></i>
            </div>
         </div>
         <div class="card-body">
            
         </div>
      </div>
   </div>
   @endforeach
</div>
@endforeach