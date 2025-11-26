   <aside class="amd-book-profile__sidebar ">
       <div class="amd-book-profile__avatar-wrapper">
           <img src="{{ asset('storage/profile_images/' . $data['userDetail']->profile_image ?? 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR7PIVl6sCfi3RNfHTgtLC6gKZF8JBhaJwUog&s') }}"
               alt="{{ $data['userDetail']->full_name ?? $data['userDetail']->name }}" class="amd-book-profile__avatar">
       </div>

       <h1 class="amd-book-profile__author-name">
           {{ $data['userDetail']->full_name ?? $data['userDetail']->name }}
       </h1>

       <p class="amd-book-profile__member-since">Member since {{ $data['userDetail']->created_at->format('M d, Y') }}
       </p>

       <ul class="amd-book-profile__nav">
           <li class="amd-book-profile__nav-item {{ request()->routeIs('site.user.profile') ? 'active' : '' }}">
               <a href="{{ route('site.user.profile', ['locale' => app()->getLocale()]) }}">Profile Details</a>
           </li>

           <li class="amd-book-profile__nav-item {{ request()->routeIs('site.user.bookmark') ? 'active' : '' }}">
               <a
                   href="{{ route('site.user.bookmark', [
                       'locale' => app()->getLocale(),
                       'id' => $data['userDetail']->id,
                   ]) }}">BookMarks</a>
           </li>
       </ul>


   </aside>
