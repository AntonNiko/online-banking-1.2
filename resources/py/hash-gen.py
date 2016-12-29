import hashlib
import sys

def main(data):
    try:
        import sha3
    except ImportError:
        sys.stdout.write("ImportError")
        return
    handler = hashlib.sha3_256()
    handler.update(data.encode())
    result = handler.hexdigest()
    sys.stdout.write(result)

sys.stdout.flush()
if len(sys.argv)>1:
    main(sys.argv[1])
