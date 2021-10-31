<!--begin::Notifications-->
<div class="dropdown">
    <!--begin::Toggle-->
    <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
        <div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 pulse pulse-primary">
											<span class="svg-icon svg-icon-xl svg-icon-primary">
												<!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
												<span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\legacy\metronic\theme\html\demo1\dist/../src/media/svg/icons\General\Notifications1.svg--><svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                            height="24px" viewBox="0 0 24 24" version="1.1">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <path
                d="M17,12 L18.5,12 C19.3284271,12 20,12.6715729 20,13.5 C20,14.3284271 19.3284271,15 18.5,15 L5.5,15 C4.67157288,15 4,14.3284271 4,13.5 C4,12.6715729 4.67157288,12 5.5,12 L7,12 L7.5582739,6.97553494 C7.80974924,4.71225688 9.72279394,3 12,3 C14.2772061,3 16.1902508,4.71225688 16.4417261,6.97553494 L17,12 Z"
                fill="#000000"/>
        <rect fill="#000000" opacity="0.3" x="10" y="16" width="4" height="4" rx="2"/>
    </g>
</svg><!--end::Svg Icon--></span>
                                                <!--end::Svg Icon-->
											</span>
            <span class="pulse-ring"></span>
        </div>
    </div>
    <!--end::Toggle-->
    <!--begin::Dropdown-->
    <div
            class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
        <form>
        @php
            $notifications = auth()->guard('admin')->user()->unreadNotifications()->get()->sortByDesc('created_at');
            $count = count($notifications);
        @endphp
        <!--begin::Header-->
            <div class="d-flex flex-column pt-3 bgi-size-cover bgi-no-repeat rounded-top"
                 style="background-image: url(assets/media/misc/bg-1.jpg)">
                <!--begin::Title-->
                <h4 class="d-flex flex-center rounded-top">
                    <span class="text-white">اشعارات المدير</span>
                    <span
                            class="btn btn-text btn-success btn-sm font-weight-bold btn-font-md ml-2"> <span
                                class="count-noti">{{$count}}</span> جديد</span>
                </h4>
                <!--end::Title-->
            </div>
            <!--end::Header-->
            <!--begin::Content-->
            <div class="tab-content">
                <!--begin::Tabpane-->
                <div class="tab-pane active show  pl-8 pr-8 pb-8" id="topbar_notifications_notifications"
                     role="tabpanel">
                    <!--begin::Scroll-->
                    <div class="scroll pr-7 mr-n7" data-scroll="true" data-height="300"
                         data-mobile-height="200">
                        <!--begin::Notifications-->
                        <div>
                            <!--begin:Heading-->
                            <h5 class="mb-5">أحدث الإشعارات</h5>
                            <!--end:Heading-->
                            <div id="notif">
                            @foreach($notifications as $notification)
                                @php
                                    $log = $notification->data['log'];

                                $permission =\App\Models\Permission::find($log['permission']['id']);
                                @endphp
                                <!--begin::Item-->

                                    <div class="d-flex align-items-center bg-light-warning rounded p-5 gutter-b">
						<span class="svg-icon svg-icon-warning mr-5">
							<span class="svg-icon svg-icon-lg">
								<!--begin::Svg Icon | path:assets/media/svg/icons/Home/Library.svg-->
                                <i class="{{$log['permission']['icon']}}"></i>
                                <!--end::Svg Icon-->
							</span>
						</span>
                                        <div class="d-flex flex-column flex-grow-1 mr-2">
                                            <a onclick="javascript:pop(this);"
                                               href="{{url("").($log['path_status']?$log['permission']['link']:$permission->parent->childes->first()->link)}}"
                                               the_id="{{$notification->id}}"
                                               class="font-weight-normal text-dark-75 text-hover-primary font-size-lg mb-1">{{$log['permission']['title']}}</a>
                                            <span class="text-muted font-size-sm">{{date('d-m-Y', strtotime($log['created_at']))}}</span>
                                        </div>
                                        <span class="font-weight-bolder text-warning py-1 font-size-lg">{{$log['logable']['name']}}</span>
                                    </div>

                                    <!--end::Item-->
                                @endforeach
                            </div>
                        </div>
                        <!--end::Notifications-->
                    </div>
                    <!--end::Scroll-->
                    <!--begin::Action-->
                    <div class="d-flex flex-center pt-7">
                        <a href="{{admin_notification_url()}}"
                           class="btn btn-light-primary font-weight-bold text-center">
                            عرض الكل</a>
                    </div>
                    <!--end::Action-->
                </div>
                <!--end::Tabpane-->
                <!--begin::Tabpane-->
                <div class="tab-pane" id="topbar_notifications_logs" role="tabpanel">
                    <!--begin::Nav-->
                    <div class="d-flex flex-center text-center text-muted min-h-200px">
                        قم بالتحديث!
                        <br/>لا يوجد اشعارات جديدة.
                    </div>
                    <!--end::Nav-->
                </div>
                <!--end::Tabpane-->
            </div>
            <!--end::Content-->
        </form>
    </div>
    <!--end::Dropdown-->
</div>
<!--end::Notifications-->