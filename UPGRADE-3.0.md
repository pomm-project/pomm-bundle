UPGRADE FROM 2.x to 3.0
=======================

### Configuration

 * `class:session_builder` has been removed in favour of defining session builder as a service, this is to support the
  models and model layers as a service.
  If you need custom session builder then you should define it as a service and then add it to the configuration under
  `session_builder` key.

### Property info

* The `pomm.property_info` service was removed. You must use
  `pomm.property_type_info` instead.
