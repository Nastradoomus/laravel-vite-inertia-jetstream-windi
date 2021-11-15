import { dateToStringYYYYMMDD } from "./dateFunctions"

const url = process.env.MIX_APP_URL
// const apiUrl = `${url}/api`;

// RESTAURANT
export const getRestaurantLunchApiUrl = (start, end) => {
	const result = `${url}/restaurant/lunch/authorized?start_date=${dateToStringYYYYMMDD(
		start
	)}&end_date=${dateToStringYYYYMMDD(end)}`
	return result
}

export const getRestaurantLunchDefaultsApiUrl = () => {
	const result = `${url}/restaurant/defaults/authorized/lunch`
	return result
}

export const postRestaurantLunchDateDefaultsApiUrl = () => {
	const result = `${url}/restaurant/lunch/authorized/date/defaults`
	return result
}

export const postRestaurantLunchDateApiUrl = () => {
	const result = `${url}/restaurant/lunch/authorized/date`
	return result
}

export const postRestaurantLunchApiUrl = () => {
	const result = `${url}/restaurant/lunch/authorized/post`
	return result
}
export const deleteRestaurantLunchApiUrl = () => {
	const result = `${url}/restaurant/lunch/authorized/delete`
	return result
}
export const postRestaurantLunchDefaultsApiUrl = () => {
	const result = `${url}/defaults/authorized`
	return result
}

export const postRestaurantItemApiUrl = () => {
	const result = `${url}/restaurant/menu/authorized/item`
	return result
}
export const deleteRestaurantItemApiUrl = () => {
	const result = `${url}/restaurant/menu/authorized/item/delete`
	return result
}

export const postRestaurantTypeApiUrl = () => {
	const result = `${url}/restaurant/menu/authorized/type`
	return result
}

// CAFE
export const postCafeItemApiUrl = () => {
	const result = `${url}/cafe/authorized/item`
	return result
}

export const deleteCafeItemApiUrl = () => {
	const result = `${url}/cafe/authorized/item/delete`
	return result
}

export const postCafeTypeApiUrl = () => {
	const result = `${url}/cafe/authorized/type`
	return result
}

export const postCafeDataApiUrl = () => {
	const result = `${url}/cafe/authorized/data`
	return result
}

// PORTION
export const getPortionsApiUrl = () => {
	const result = `${url}/portions/authorized/`
	return result
}
export const postPortionApiUrl = () => {
	const result = `${url}/portions/authorized/portion`
	return result
}
export const getPortionsSearchApiUrl = (title) => {
	const result = `${url}/portions/authorized/search?title=${title}`
	return result
}
export const checkPortionApiUrl = (title) => {
	const result = `${url}/portions/authorized/check?title=${title}`
	return result
}
export const deletePortionApiUrl = () => {
	const result = `${url}/portions/authorized/portion`
	return result
}

// SERVICE HOURS
export const postServiceHoursApiUrl = () => {
	const result = `${url}/servicehours/authorized/servicehour`
	return result
}
