import {Injectable} from '@angular/core';

@Injectable()
export class ArrayHelperService {

	constructor() {
	}

	static isArray(value): boolean {
		return value instanceof Array;
	}
}
