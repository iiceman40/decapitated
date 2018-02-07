import {Component, OnInit} from '@angular/core';
import {environment} from '../../../environments/environment';
import {HttpClient} from '@angular/common/http';
import {ObjectHelperService} from '../../helper/objectHelper/object-helper.service';
import {AuthService} from '../../services/authService/auth.service';
import {Router} from '@angular/router';

@Component({
	selector: 'app-login',
	templateUrl: './login.component.html',
	styleUrls: ['./login.component.scss']
})
export class LoginComponent implements OnInit {

	credentials = {
		username: '',
		password: ''
	};

	constructor(private _httpClient: HttpClient,
	            private _authService: AuthService,
	            private _router: Router) {
	}

	ngOnInit() {
		// TODO maybe use a route guard for that?
		// if(this._authService.isAuthenticated()) {
		// 	this._router.navigate((['/home']));
		// }
	}

	login() {
		const body = this.credentials;
		this._httpClient.post(`${environment.apiUri}/auth/getToken`, body)
			.subscribe((response: {token: string}) => {
				this._authService.setToken(response.token);
				this._router.navigate((['/home']));
				// TODO show errors on failure
			});
	}
}
