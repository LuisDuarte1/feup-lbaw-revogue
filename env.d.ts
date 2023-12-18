interface ImportMetaEnv {
  readonly VITE_PUSHER_APP_KEY: string
  readonly VITE_PUSHER_APP_CLUSTER: string
  readonly VITE_PUSHER_HOST: string | undefined
  readonly VITE_PUSHER_PORT: number
  readonly VITE_PUSHER_SCHEME: string | undefined
  // more env variables...
}

interface ImportMeta {
  readonly env: ImportMetaEnv
}
