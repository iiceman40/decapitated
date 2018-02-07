import {BrowserModule} from '@angular/platform-browser';
import {NgModule} from '@angular/core';

import {AppComponent} from './app.component';
import {HomeComponent} from './pages/home/home.component';
import {InstallComponent} from './pages/install/install.component';
import {AppRoutingModule} from './app-routing.module';
import {HTTP_INTERCEPTORS, HttpClientModule} from '@angular/common/http';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {AppMaterialModule} from './app-material.module';
import {FlexLayoutModule} from '@angular/flex-layout';
import {ConfigStructureResolver} from './guards/config-structure-resolver';
import {FormsModule} from '@angular/forms';
import {LoginComponent} from './pages/login/login.component';
import {AuthService} from './services/authService/auth.service';
import {TokenInterceptor} from './interceptors/tokenInterceptor';
import {AuthGuard} from './guards/auth-guard';
import {ArrayHelperService} from './helper/arrayHelper/array-helper.service';
import {ObjectHelperService} from './helper/objectHelper/object-helper.service';
import {JwtHelper} from 'angular2-jwt';


@NgModule({
	declarations: [
		AppComponent,
		HomeComponent,
		InstallComponent,
		LoginComponent
	],
	imports: [
		BrowserModule,
		HttpClientModule,
		BrowserAnimationsModule,
		FlexLayoutModule,
		AppRoutingModule,
		AppMaterialModule,
		FormsModule
	],
	providers: [
		ConfigStructureResolver,
		AuthGuard,
		ObjectHelperService,
		ArrayHelperService,
		AuthService,
		JwtHelper,
		{
			provide: HTTP_INTERCEPTORS,
			useClass: TokenInterceptor,
			multi: true
		}
	],
	bootstrap: [AppComponent]
})
export class AppModule {
}
