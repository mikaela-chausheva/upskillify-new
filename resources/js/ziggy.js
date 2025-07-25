const Ziggy = {"url":"http:\/\/localhost","port":null,"defaults":{},"routes":{"home":{"uri":"\/","methods":["GET","HEAD"]},"register.store":{"uri":"register","methods":["POST"]},"login.view":{"uri":"login","methods":["GET","HEAD"]},"login.store":{"uri":"login","methods":["POST"]},"logout":{"uri":"logout","methods":["POST"]},"course.viewCreate":{"uri":"createCourse","methods":["GET","HEAD"]},"course.store":{"uri":"storeCourse","methods":["POST"]},"courses.mine":{"uri":"my-courses","methods":["GET","HEAD"]},"courses.list":{"uri":"courses","methods":["GET","HEAD"]},"courses.show":{"uri":"courses\/{course}","methods":["GET","HEAD"],"parameters":["course"],"bindings":{"course":"id"}},"lessons.create":{"uri":"courses\/{course}\/lessons\/create","methods":["GET","HEAD"],"parameters":["course"],"bindings":{"course":"id"}},"lessons.store":{"uri":"courses\/{course}\/lessons","methods":["POST"],"parameters":["course"],"bindings":{"course":"id"}},"lessons.show":{"uri":"courses\/{course}\/lessons\/{lesson}","methods":["GET","HEAD"],"parameters":["course","lesson"],"bindings":{"course":"id","lesson":"id"}},"lessons.edit":{"uri":"courses\/{course}\/lessons\/{lesson}\/edit","methods":["GET","HEAD"],"parameters":["course","lesson"],"bindings":{"course":"id","lesson":"id"}},"lessons.update":{"uri":"courses\/{course}\/lessons\/{lesson}","methods":["PUT"],"parameters":["course","lesson"],"bindings":{"course":"id","lesson":"id"}},"courses.checkout":{"uri":"courses\/{course}\/checkout","methods":["POST"],"parameters":["course"],"bindings":{"course":"id"}},"storage.local":{"uri":"storage\/{path}","methods":["GET","HEAD"],"wheres":{"path":".*"},"parameters":["path"]}}};
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
  Object.assign(Ziggy.routes, window.Ziggy.routes);
}
export { Ziggy };
