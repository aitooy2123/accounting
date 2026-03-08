<tr>
  <td class="text-center">{{ $account->code }}</td>

  <td>
    {!! str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level) !!}
    @if ($level > 0)
      └─
    @endif
    {{ $account->name }}
  </td>

  <td>{{ $account->type }}</td>

  <td class="text-right">
    {{ number_format($account->balance, 2) }}
  </td>

  <td class="text-center text-nowrap">
    <a href="{{ route('accounts.edit', $account) }}" class="btn btn-outline-warning btn-modern">แก้ไข</a>

    <form action="{{ route('accounts.destroy', $account) }}" method="POST" style="display:inline;" onsubmit="confirmDelete(this)">
      @csrf
      @method('DELETE')
      <button class="btn btn-sm btn-outline-danger btn-modern">ลบ</button>
    </form>
  </td>
</tr>

@if ($account->children)
  @foreach ($account->children as $child)
    @include('accounts.partials.row', ['account' => $child, 'level' => $level + 1])
  @endforeach
@endif
