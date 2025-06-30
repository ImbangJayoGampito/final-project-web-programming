 @foreach (['success' => 'success', 'error' => 'danger', 'info' => 'info'] as $msg => $type)
     @if ($msgValue = session($msg))
         <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
             {{ ucfirst($msg) }}: {{ is_array($msgValue) ? implode(', ', $msgValue) : $msgValue }}
             @if ($msg === 'success')
                 <div class="mt-1 small text-muted">Your changes have been successfully saved into the system.</div>
             @endif
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
         </div>
     @endif
 @endforeach
