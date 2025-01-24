<!-- resources/views/transactionSummaryReport.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Loyalty Transaction Summary</h2>

        <!-- Display error message if no transactions found -->
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(isset($transactions) && count($transactions) > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Transaction ID</th>
                        <th>Order ID</th>
                        <th>User ID</th>
                        <th>Total Points Used</th>
                        <th>Points Earned</th>
                        <th>Transaction Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->TransactionUniqueIdentifier }}</td>
                            <td>{{ $transaction->OrderUniqueIdentifier }}</td>
                            <td>{{ $transaction->UserUniqueIdentifier }}</td>
                            <td>{{ $transaction->TotalPointsUsed }}</td>
                            <td>{{ $transaction->PointsEarned }}</td>
                            <td>{{ $transaction->TransactionDate }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No transactions found for the provided Loyalty ID.</p>
        @endif
    </div>
@endsection
