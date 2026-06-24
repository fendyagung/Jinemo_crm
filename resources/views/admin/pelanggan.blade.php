@extends('layouts.admin')

@section('content')
<h1 class="mb-2">Kelola Pelanggan</h1>
<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Email</th>
                <th>Loyalty Point</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $index => $customer)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->email }}</td>
                <td style="color: var(--primary); font-weight: bold;">{{ $customer->point }} Pts</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
