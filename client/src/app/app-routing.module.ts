import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {HomeComponent} from './pages/home/home.component';
import {InstallComponent} from './pages/install/install.component';
import {ConfigStructureResolver} from './guards/config-structure-resolver';
import {LoginComponent} from './pages/login/login.component';
import {AuthGuard} from './guards/auth-guard';

const appRoutes: Routes = [
	{
		path: 'home',
		component: HomeComponent,
		canActivate: [AuthGuard],
		data: {
			state: 'home'
		}
	},
	{
		path: 'login',
		component: LoginComponent,
		data: {
			state: 'login'
		}
	},
	{
		path: 'install',
		component: InstallComponent,
		resolve: {
			configStructure: ConfigStructureResolver
		},
		data: {
			state: 'install'
		}
	},
	//{path: 'bewerbung/:refCode', component: JobApplicationComponent, data: {state: 'jobapplication'}},
	{path: '', redirectTo: '/home', pathMatch: 'full'},
];

@NgModule({
	imports: [
		RouterModule.forRoot(
			appRoutes, // {enableTracing: true} // <-- debugging purposes only
		)
	],
	exports: [
		RouterModule
	]
})
export class AppRoutingModule {
}