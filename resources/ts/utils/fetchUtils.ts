import { echo } from '../bootstrap'

export async function fetchWithSocketInformation (url: string, requestInfo?: RequestInit | undefined): Promise<Response> {
  if (requestInfo === undefined) {
    const normalRequestInfo: RequestInit = { headers: new Headers({ 'X-Socker-ID': echo.socketId() }) }
    return fetch(url, normalRequestInfo)
  }
  if (requestInfo.headers === undefined) {
    requestInfo.headers = new Headers({ 'X-Socket-ID': echo.socketId() })
  } else if (requestInfo.headers instanceof Headers) {
    requestInfo.headers.set('X-Socket-ID', echo.socketId())
  } else {
    requestInfo.headers = new Headers(requestInfo.headers)
    requestInfo.headers.set('X-Socket-ID', echo.socketId())
    console.log(requestInfo.headers)
  }
  return fetch(url, requestInfo)
}
