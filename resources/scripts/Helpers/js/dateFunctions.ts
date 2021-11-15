export function correctOffset(date) {
	const result = new Date(date)
	result.setTime(result.getTime() - result.getTimezoneOffset() * 60 * 1000)
	return result
}

export function addDays(date, days) {
	const result = new Date(date)
	result.setDate(result.getDate() + days)
	return result
}

export function removeDays(date, days) {
	const result = new Date(date)
	result.setDate(result.getDate() - days)
	return result
}

export function parseISOString(string) {
	const b = string.split(/\D+/)
	const result = new Date(Date.UTC(b[0], (b[1] -= 1), b[2], b[3], b[4], b[5], b[6]))
	return result
}

export function ISOStringToDate(string) {
	const result = parseISOString(string)
	return result
}

export function dateToStringYYYYMMDD(date) {
	const result = new Date(date).toISOString().split("T")[0]
	return result
}
