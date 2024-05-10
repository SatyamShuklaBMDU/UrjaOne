@extends('include.master')
@section('content')
    <div class="mb-sm-4 d-flex flex-wrap align-items-center text-head">
        <h2 class="mb-3 me-auto">Dashboard</h2>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="row">
                <div class="col-xl-6 col-sm-6">
                    <div class="card">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="menu">
                                <span class="font-w500 fs-16 d-block mb-2">Total Users</span>
                                <h2>{{$user}}</h2>
                            </div>
                            <div class="d-inline-block position-relative donut-chart-sale">
                                <span class="donut1"
                                    data-peity='{ "fill": ["rgb(98, 79, 209,1)", "rgba(247, 245, 255)"],   "innerRadius": 35, "radius": 10}'>5/7</span>
                                <small class="text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="30" width="36"
                                        viewBox="0 0 640 512">
                                        <path fill="#624FD1"
                                            d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z" />
                                    </svg>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-6">
                    <div class="card">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="menu">
                                <span class="font-w500 fs-16 d-block mb-2">Total Enquiry</span>
                                <h2>561</h2>
                            </div>
                            <div class="d-inline-block position-relative donut-chart-sale">
                                <span class="donut1"
                                    data-peity='{ "fill": ["rgb(98, 79, 209,1)", "rgba(247, 245, 255)"],   "innerRadius": 35, "radius": 10}'>5/6</span>
                                <small class="text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="30" width="36"
                                        viewBox="0 0 512 512">
                                        <path
                                            d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336h24V272H216c-13.3 0-24-10.7-24-24s10.7-24 24-24h48c13.3 0 24 10.7 24 24v88h8c13.3 0 24 10.7 24 24s-10.7 24-24 24H216c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z "
                                            fill="#624FD1" />
                                    </svg>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-6">
                    <div class="card">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="menu">
                                <span class="font-w500 fs-16 d-block mb-2">Total Complaints</span>
                                <h2>{{$complaint}}</h2>
                            </div>
                            <div class="d-inline-block position-relative donut-chart-sale">
                                <span class="donut1"
                                    data-peity='{ "fill": ["rgb(98, 79, 209,1)", "rgba(247, 245, 255)"],   "innerRadius": 35, "radius": 10}'>5/8</span>
                                <small class="text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="30" width="36"
                                        viewBox="0 0 384 512">
                                        <path fill="#624FD1"
                                            d="M192 0c-41.8 0-77.4 26.7-90.5 64H64C28.7 64 0 92.7 0 128V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V128c0-35.3-28.7-64-64-64H282.5C269.4 26.7 233.8 0 192 0zm0 64a32 32 0 1 1 0 64 32 32 0 1 1 0-64zM105.8 229.3c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L216 328.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V314.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H158.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM160 416a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z" />
                                    </svg>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-6">
                    <div class="card">
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <div class="menu">
                                <span class="font-w500 fs-16 d-block mb-2">Total Feedback</span>
                                <h2>{{$feedback}}</h2>
                            </div>
                            <div class="d-inline-block position-relative donut-chart-sale">
                                <span class="donut1"
                                    data-peity='{ "fill": ["rgb(98, 79, 209,1)", "rgba(247, 245, 255)"],   "innerRadius": 35, "radius": 10}'>5/7</span>
                                <small class="text-black">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="30" width="36"
                                        viewBox="0 0 512 512">
                                        <path
                                            d="M256 448c141.4 0 256-93.1 256-208S397.4 32 256 32S0 125.1 0 240c0 45.1 17.7 86.8 47.7 120.9c-1.9 24.5-11.4 46.3-21.4 62.9c-5.5 9.2-11.1 16.6-15.2 21.6c-2.1 2.5-3.7 4.4-4.9 5.7c-.6 .6-1 1.1-1.3 1.4l-.3 .3 0 0 0 0 0 0 0 0c-4.6 4.6-5.9 11.4-3.4 17.4c2.5 6 8.3 9.9 14.8 9.9c28.7 0 57.6-8.9 81.6-19.3c22.9-10 42.4-21.9 54.3-30.6c31.8 11.5 67 17.9 104.1 17.9zM128 208a32 32 0 1 1 0 64 32 32 0 1 1 0-64zm128 0a32 32 0 1 1 0 64 32 32 0 1 1 0-64zm96 32a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"
                                            fill="#624FD1" />
                                    </svg>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header border-0 flex-wrap pb-0">
                    <div class="mb-sm-0 mb-2">
                        <h4 class="fs-20">Today’s Users</h4>
                        <span>Lorem ipsum dolor sit amet, consectetur</span>
                    </div>
                    <div>
                        <h2 class="font-w700 mb-0">204</h2>
                        <p class="mb-0 font-w700"><span class="text-success">0,5% </span>than
                            last day</p>
                    </div>
                </div>
                <div class="card-body py-0">
                    <div id="revenueChart" class="revenueChart"></div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-xxl-12">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header border-0  flex-wrap">
                            <div>
                                <h4 class="fs-20 mb-1">All Enquiry</h4>
                                <span>Lorem ipsum dolor sit amet, consectetur</span>
                            </div>
                            <div class="d-flex">
                                <div class="card-action coin-tabs mt-3 mt-sm-0">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-bs-toggle="tab" href="#Monthly"
                                                role="tab">Monthly</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " data-bs-toggle="tab" href="#Daily"
                                                role="tab">Daily</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#Today"
                                                role="tab">Today</a>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <div class="card-body pb-2">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="Monthly">
                                    <div id="chartTimeline1" class="chart-timeline"></div>
                                </div>
                                <div class="tab-pane fade " id="Daily">
                                    <div id="chartTimeline2" class="chart-timeline"></div>
                                </div>
                                <div class="tab-pane fade " id="Today">
                                    <div id="chartTimeline3" class="chart-timeline"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-xxl-12">
                    <div class="row">
                        <div class="col-xl-12">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
