<ul class="navbar-nav mr-auto">
	@if (Auth::user())

	@if (Auth::user()->can('viewAny', App\Models\ReceiptOfMaterial::class))
	<li class="nav-item">
		<a class="nav-link" href="{{ route('receipts.index') }}">
			{{ trans_choice('text.receipt', 2) }}
		</a>
	</li>
	@endif	

	@if (Auth::user()->can('viewAny', App\Models\WriteOffOfMaterial::class))
	<li class="nav-item">
		<a class="nav-link" href="{{ route('writeoffs.index') }}">
			{{ trans_choice('text.writeoff', 2) }}
		</a>
	</li>
	@endif	

	
	@if (Auth::user()->can('viewAny', App\Models\OrderMaterial::class))
	<li class="nav-item">
		<a class="nav-link" href="{{ route('orders.index') }}">
			{{ trans_choice('text.order', 2) }}
		</a>
	</li>
	@endif	


	@if (Auth::user()->can('viewAny', App\Models\User::class))
	<li class="nav-item">
		<a class="nav-link" href="{{ route('users.index') }}">
			{{ trans_choice('text.user', 2) }}
		</a>
	</li>
	@endif

	

	@if (Auth::user()->can('viewAny', App\Models\WriteOffOfMaterial::class))
	<li class="nav-item">
		<a class="nav-link" href="{{ route('home.showbalance') }}">
			{{ trans_choice('text.showbalance', 1) }}
		</a>
	</li>
	@endif



	<!--
	<a href="{{ url('locale/en') }}" class="{{ App::isLocale('en') ? 'active' : '' }}">EN</a>
	-->


	@endif



</ul>

