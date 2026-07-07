import React from 'react'
import { AuthLayout } from '../Layouts/AuthLayout'

const Test = () => {
  return (
    <div>Test 2</div>
  )
}

Test.layout = page => <AuthLayout children={page} title="Test" />
export default Test