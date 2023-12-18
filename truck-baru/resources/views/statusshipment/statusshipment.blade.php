@if ($key->f_status == 'New')
<span class="badge bg-danger">{{ $key->f_status }}</span>
@elseif($key->f_status == 'Payout')
<span class="badge bg-warning">{{ $key->f_status }}</span>
@elseif($key->f_status == 'Loading')
<span class="badge bg-success">{{ $key->f_status }}</span>
@elseif($key->f_status == 'Shiping')
<span class="badge bg-info">{{ $key->f_status }}</span>
@elseif($key->f_status == 'Settlement')
<span class="badge bg-primary">{{ $key->f_status }}</span>
@elseif($key->f_status == 'Cancel')
<span class="badge bg-secondary">{{ $key->f_status }}</span>
@endif
