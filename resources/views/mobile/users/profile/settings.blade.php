@extends('mobile.users.layout.plainBase')
@section('content')

   <div class="mt-4">
       <livewire:mobile.users.profile.settings  lazy />
   </div>

   @push('js')
       <script>
           window.addEventListener('clear-success-message', () => {
               setTimeout(() => {
                   Livewire.dispatch('clearSuccessMessage');
               }, 5000);
           });
       </script>

       <script>
           window.addEventListener('renderPage', () => {
               setTimeout(() => {
                   window.location.reload();
               }, 4000);
           });
       </script>
   @endpush
@endsection
