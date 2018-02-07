import { Injectable }     from '@angular/core';
import {CanActivate, Router} from '@angular/router';
import {AuthService} from '../services/authService/auth.service';

@Injectable()
export class AuthGuard implements CanActivate {

	constructor(private _authService: AuthService, private _router: Router) {
	}

	canActivate() {
		const isAuthenticated = this._authService.isAuthenticated();

		if(isAuthenticated === false) {
			this._router.navigate(['/login']);
		}

		return isAuthenticated;
	}
}