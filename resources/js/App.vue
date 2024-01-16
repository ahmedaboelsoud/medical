<template>
	<div class="page-sidebar-wrapper">
		<div class="page-sidebar navbar-collapse collapse">
			<ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
				<!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
				<li class="sidebar-toggler-wrapper">
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler">
					</div>
					<!-- END SIDEBAR TOGGLER BUTTON -->
				</li>
				<!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
			   <br/>
			   <li :class="{active: $route.matched.some(({ name }) => name === 'dashboard')}">
					<router-link :to="{ name: 'dashboard', }" >
						<i class="icon-rocket"></i>
						<span class="title">{{ this.$t("dashboard.dashboard") }}</span>
					 </router-link>
				</li>
				<li :class="{active: $route.matched.some(({ name }) => name === 'patients')}">
					<router-link :to="{ name: 'patients', }" >
						<i class="icon-rocket"></i>
						<span class="title">{{ this.$t("patients.patients") }}</span>
					 </router-link>
				</li>
				<li :class="{active: $route.matched.some(({ name }) => name === 'doctors')}">
					<router-link :to="{ name: 'doctors' }" >
						<i class="icon-rocket"></i>
						<span class="title">{{ this.$t("doctors.doctors") }}</span>
					</router-link>
				</li>
				<li :class="{active: $route.matched.some(({ name }) => name === 'appointments')}">
					<router-link :to="{ name: 'appointments' }" >
						<i class="icon-rocket"></i>
						<span class="title">{{ this.$t("appointments.appointments") }}</span>
					</router-link>
				</li>
				<li :class="{active: $route.matched.some(({ name }) => name === 'management')}">
					<router-link :to="{ name: 'management' }" >
						<i class="icon-rocket"></i>
						<span class="title">{{ this.$t("management.management") }}</span>
					</router-link>
				</li>			
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>
	</div>
	<!-- END SIDEBAR -->
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
			<div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Modal title</h4>
						</div>
						<div class="modal-body">
							 Widget settings form goes here
						</div>
						<div class="modal-footer">
							<button type="button" class="btn blue">Save changes</button>
							<button type="button" class="btn default" data-dismiss="modal">Close</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
			<div class="row">
				<div class="col-md-12">
                    <!-- table content  -->
                    <!-- <router-view :key="$route.fullPath"></router-view> -->
					<router-view></router-view>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div> 
</template>
<script>
export default {
  data() {
    return {
		page: this.$route.name,
	}
  }
}
</script>