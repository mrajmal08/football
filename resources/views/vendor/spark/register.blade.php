@extends('spark::layouts.app')

@section('scripts')
    @if (Spark::billsUsingStripe())
        <script src="https://js.stripe.com/v3/"></script>
    @else
        <script src="https://js.braintreegateway.com/v2/braintree.js"></script>
    @endif
@endsection

@section('content')
    <spark-settings :user="user" :teams="teams" inline-template>
        <div class="spark-screen container">
            <div class="row">
                <!-- Tabs -->
                <div class="col-md-0 spark-settings-tabs">
                  

                  
                    @if (Spark::canBillCustomers())
                        <aside>
                           
                            <ul class="nav flex-column mb-1 ">
                                @if (Spark::hasPaidPlans())
                                    <li class="nav-item ">
                                        <a class="nav-link" href="#subscription" aria-controls="subscription" role="tab" data-toggle="tab">      
                                        </a>
                                    </li>
                                @endif

                              

                           
                            </ul>
                        </aside>
                    @endif
                </div>
				
                <!-- Tab cards -->
                <div class="col-md-12">
                    <div class="tab-content">
						

                    <!-- Billing Tab Panes -->
                        @if (Spark::canBillCustomers())
                            @if (Spark::hasPaidPlans())
                            <!-- Subscription -->
                                <div role="tabcard" class="tab-pane" id="subscription">
                                    <div v-if="user">
                                        @include('spark::settings.subscription')
                                    </div>
                                </div>
                            @endif

                        <!-- Payment Method -->
                            <div role="tabcard" class="tab-pane" id="payment-method">
                                <div v-if="user">
                                    @include('spark::settings.payment-method')
                                </div>
                            </div>

                            <!-- Invoices -->
                            <div role="tabcard" class="tab-pane" id="invoices">
                                @include('spark::settings.invoices')
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </spark-settings>
@endsection
