import {Injectable} from '@angular/core';
import {
	HttpRequest,
	HttpHandler,
	HttpEvent,
	HttpInterceptor
} from '@angular/common/http';
import {Observable} from 'rxjs/Observable';
import {AuthService} from '../services/authService/auth.service';

@Injectable()
export class TokenInterceptor implements HttpInterceptor {
	constructor(private _auth: AuthService) {
	}

	intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
		const token = this._auth.getToken();
		console.log('http interceptor', token);

		if(token) {
			request = request.clone({
				setHeaders: {
					Authorization: `Bearer ${token}`
				}
			});
		}

		return next.handle(request);
	}
}