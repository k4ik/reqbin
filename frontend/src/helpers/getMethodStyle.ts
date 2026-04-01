export function getMethodStyle(method: string) {
    switch (method.toUpperCase()) {
        case 'GET':
            return {
                color: '#16a34a',
                background: '#dcfce7'
            }
        case 'POST':
            return {
                color: '#2563eb',
                background: '#dbeafe'
            }
        case 'PUT':
            return {
                color: '#d97706',
                background: '#fef3c7'
            }
        case 'DELETE':
            return {
                color: '#dc2626',
                background: '#fee2e2'
            }
        case 'PATCH':
            return {
                color: '#7c3aed',
                background: '#ede9fe'
            }
        default:
            return {
                color: '#374151',
                background: '#e5e7eb'
            }
    }
}