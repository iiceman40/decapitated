import {Injectable} from '@angular/core';

@Injectable()
export class ObjectHelperService {

	constructor() {
	}

	static objectToKeyValueArray(object: Object): Array<any> {
		let array = [];
		for (let key in object) {
			if (object.hasOwnProperty(key)) {
				array.push({
					key: key,
					val: object[key] !== null && typeof object[key] === 'object' ?
						ObjectHelperService.objectToKeyValueArray(object[key]) :
						object[key]
				});
			}
		}
		return array;
	}

	static keyValueArrayToObject(array: { key: string, val: any }[]) {
		let object = {};

		array.forEach(keyValuePair => {
			object[keyValuePair.key] = keyValuePair.val instanceof Array ?
				ObjectHelperService.keyValueArrayToObject(keyValuePair.val) :
				keyValuePair.val;
		});

		return object;
	}
}
